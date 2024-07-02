<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ClienteController extends Controller
{
    public function index()
    {

        $sql = DB::select(" SELECT
        cliente.id_membresia,
        cliente.tipo_usuario,
        cliente.creado_por,
        cliente.usuario,
        cliente.pago,
        cliente.`password`,
        cliente.dni,
        cliente.debe,
        cliente.nombre,
        cliente.correo,
        cliente.telefono,
        cliente.direccion,
        date(cliente.desde)as 'desde',
        date(cliente.hasta)as 'hasta',
        cliente.DT,
        cliente.DA,
        cliente.DR,
        cliente.foto,
        membresia.nombre AS nomMem,
        membresia.precio,
        cliente.id_cliente
        FROM cliente INNER JOIN membresia ON cliente.id_membresia = membresia.id_membresia ");

        return view("vistas/cliente/cliente", compact("sql"));
    }

    public function create()
    {
        $membresia = DB::select("select * from membresia");
        return view("vistas/cliente/registrar")->with("membresia", $membresia);
    }

    public function store(Request $request)
    {
        $request->validate([
            "membresia" => "required",
            "desde" => "required",
            "hasta" => "required",
            "dias" => "required",
            "dni" => "required|unique:App\Models\Cliente,dni",
            "usuario" => "required||unique:App\Models\Cliente,usuario",
            "password" => "required",
            "nombre" => "required",
            "correo" => [
                "required",
                "email",
                "unique:App\Models\Cliente,correo",
            ],
            "precio" => "required",
            "foto" => "mimes:jpg,jpeg,png",
            "acuenta" => "numeric"
        ]);


        $nombreUsuario = Auth::user()->nombre;
        $debe = $request->precio - $request->acuenta;

        $verifificarDuplicidad = DB::select(" select count(*) as 'total' from cliente where (usuario='$request->usuario' or dni='$request->dni')");
        if ($verifificarDuplicidad[0]->total >= 1) {
            return back()->with("AVISO", "El usuario o DNI ya está en uso");
        }

        //primero registramos los datos
        try {
            $id_registro = DB::table('cliente')->insertGetId([
                'id_membresia' => $request->membresia,
                'tipo_usuario' => 'cliente',
                'creado_por' => $nombreUsuario,
                'usuario' => $request->usuario,
                'password' => md5($request->password),
                'dni' => $request->dni,
                'nombre' => $request->nombre,
                'correo' => $request->correo,
                'telefono' => $request->telefono,
                'direccion' => $request->direccion,
                'desde' => $request->desde,
                'hasta' => $request->hasta,
                'DT' => $request->dias,
                'DA' => '0',
                'DR' => $request->dias,
                'debe' => $debe
            ]);
        } catch (\Throwable $th) {
        }

        //ahora registramos la imagen en el servidor
        try {
            $foto = $request->file("foto");
            $nombreFoto = "usuario-$id_registro" . "." . $foto->guessExtension();
            $ruta = public_path("foto/usuario/$nombreFoto");
            copy($foto, $ruta);
        } catch (\Throwable $th) {
            //throw $th;
        }

        //ahora actualizamos el campo foto de la BD
        try {
            $actualizar = DB::update("update cliente set foto='$nombreFoto' where id_cliente=$id_registro");
        } catch (\Throwable $th) {
            //throw $th;
        }


        //ahora verificamos si el monto de acuenta es > 0, entoces registramos en la tabla abonos
        if ($request->acuenta > 0) {
            try {
                $id_registro_abono = DB::table('abono')->insertGetId([
                    'monto' => $request->acuenta,
                    'cliente' => $id_registro,
                    'fecha' => Carbon::now(),
                    'recepcionista' => $nombreUsuario,
                    'derecho_pago' => "Matricula"
                ]);
            } catch (\Throwable $th) {
                //throw $th;
            }
        }


        if ($id_registro >= 1) {
            return back()->with("CORRECTO", "Cliente registrado correctamente");
        } else {
            return back()->with("INCORRECTO", "Error al registrar");
        }
    }

    public function show($id)
    {

        $sql = DB::select("select *,date(desde)as 'Ndesde',DATE_ADD(date(hasta), INTERVAL 1 DAY) as'Nhasta' from cliente where id_cliente=?", [
            $id
        ]);

        if (count($sql) <= 0) {
            return back()->with("INCORRECTO", "El cliente no existe");
        }

        $currentDate = date('Y-m-d');

        foreach ($sql as $row) {
            $Nhasta = $row->Nhasta;

            if ($Nhasta < $currentDate) {
                $Nhasta = date('Y-m-d'); // Asignar el valor del día actual a Nhasta
            }

            // Resto de tu lógica aquí
        }

        //verificar si Nhasta es menor que la fecha actual. si es menor quiero poner el dia actual


        $membresia = DB::select("select * from membresia");

        return view('vistas/cliente/renovar', compact('sql'))->with("membresia", $membresia)->with("hasta", $Nhasta);
    }

    public function edit($id)
    {

        $verificarAsistencia = DB::select(" select count(*) as 'total' from asistencia where id_cliente=$id ");

        $sql = DB::select("select *,date(desde)as 'Ndesde',date(hasta) as'Nhasta' from cliente where id_cliente=?", [
            $id
        ]);

        $membresia = DB::select("select * from membresia");

        if ($verificarAsistencia[0]->total >= 1) {
            return back()->with("INCORRECTO", "El cliente ya tiene registrada su asistencia, por lo que ya no puedes modificar datos de la membresia");
            /*return view('vistas/cliente/actualizar', compact('sql'))->with("membresia", $membresia)
                ->with("observacion", "El cliente ya tiene registrada su asistencia, por lo que ya no puedes modificar sus datos");*/
        }
        return view('vistas/cliente/actualizar', compact('sql'))->with("membresia", $membresia)
            ->with("observacion", "");
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            "membresia" => "required",
            "desde" => "required",
            "hasta" => "required",
            "dias" => "required",
            "precio" => "required",
        ]);

        try {
            $sql = DB::update("update cliente set id_membresia=?,desde=?, hasta=?, DT=?,DA=?,DR=?,debe=?  where id_cliente=?", [
                $request->membresia, $request->desde, $request->hasta, $request->dias, "0", $request->dias, $request->precio,
                $id
            ]);
            if ($sql == 0) {
                $sql = 1;
            }
        } catch (\Throwable $th) {
            $sql = 0;
        }

        if ($sql == 1) {
            return back()->with("CORRECTO", "Cliente actualizado correctamente");
        } else {
            return back()->with("INCORRECTO", "Error al actualizar");
        }
    }

    public function editarDatosCliente(Request $request)
    {

        $request->validate([
            "dni" => "required",
            "usuario" => "required",
            "nombre" => "required",
            "correo" => "required",
            "idcliente" => "required",
        ]);
        $id = $request->idcliente;

        $verifificarDuplicidad = DB::select(" select count(*) as 'total' from cliente where (usuario='$request->usuario' or dni='$request->dni' or correo='$request->correo') and id_cliente!=$id");
        if ($verifificarDuplicidad[0]->total >= 1) {
            return back()->with("AVISO", "El usuario, DNI o Correo ya está en uso");
        }


        try {
            $sql = DB::update("update cliente set usuario=?, dni=?, nombre=?,correo=?,telefono=?, direccion=? where id_cliente=?", [
                $request->usuario, $request->dni, $request->nombre, $request->correo,
                $request->telefono, $request->direccion, $id
            ]);
            if ($sql == 0) {
                $sql = 1;
            }
        } catch (\Throwable $th) {
            $sql = 0;
        }

        if ($sql == 1) {
            return back()->with("CORRECTO", "Cliente actualizado correctamente");
        } else {
            return back()->with("INCORRECTO", "Error al actualizar");
        }
    }


    public function destroy($id)
    {
        try {
            $sql = DB::delete("delete from cliente where id_cliente=?", [
                $id
            ]);
            if ($sql == 0) {
                $sql = 1;
            }
        } catch (\Throwable $th) {
            $sql = 0;
        }

        if ($sql == 1) {
            return back()->with("CORRECTO", "Cliente eliminado correctamente");
        } else {
            return back()->with("INCORRECTO", "Error al eliminar");
        }
    }


    public function consultar($id_membresia, $desde)
    {

        $consultarMes = DB::select(" select meses,modo,precio from membresia where id_membresia=$id_membresia ");
        $meses = $consultarMes[0]->meses;
        $modo = $consultarMes[0]->modo;
        $precio = $consultarMes[0]->precio;

        //calcular fecha final
        $fechaInicial = Carbon::createFromFormat('Y-m-d', $desde);
        $fechaFinal = $fechaInicial->copy()->addMonths($meses); // sumar los meses a la fecha inicial y crear una copia del objeto
        $fechaFinalISO = $fechaFinal->toDateString(); // obtener la fecha final en formato "yyyy-mm-dd"

        //calcular dias transcurridos
        $diasPasados = $fechaInicial->diffInDays($fechaFinalISO) + 1;

        //calcular cuantos domindos tiene las fechas de inicio y fin
        $domingos = 0;
        $fechaInicio = $fechaInicial;
        $fechaFin = $fechaFinalISO;
        while ($fechaInicio <= $fechaFin) {
            if ($fechaInicio->dayOfWeek == Carbon::SUNDAY) {
                $domingos++;
            }
            $fechaInicio->addDay();
        }

        $dias = $diasPasados - $domingos;

        $mesBase = $dias;
        if ($modo == "diario") {
            $diasTotales = ($dias+1);
        } else {
            if ($modo == "interdiario") {
                $diasTotales = ($mesBase / 2);
                //si $diasTotales es decimal, redondear hacia arriba
                if (fmod($diasTotales, 1) != 0) {
                    $diasTotales = ceil($diasTotales);
                }
                $diasTotales = $diasTotales * $meses + 1;
            }
        }



        return response()->json(['respuesta' => $fechaFinalISO, "dias" => $diasTotales, "precio" => $precio], 200);
    }

    public function renovar(Request $request, $id_cliente)
    {
        $request->validate([
            "membresia" => "required",
            "id_cliente" => "required",
            "precio" => "required",
            "desde" => "required",
            "hasta" => "required",
            "dias" => "required",
            "debe" => "required",
            "total" => "required",
            "acuenta" => "numeric",
            "pagoRestante" => "numeric"
        ]);

        $nombreUsuario = Auth::user()->nombre;
        $debe = $request->total - $request->acuenta;

        //aqui por el momento no se modifica el campo "desde"
        try {
            $actualizar = DB::update("update cliente set id_membresia=?, hasta=?, DT=?,DA=?,DR=?, debe=? where id_cliente=?", [
                $request->membresia,
                $request->hasta, $request->dias,
                0, $request->dias, $debe,
                $request->id_cliente
            ]);
        } catch (\Throwable $th) {
            $actualizar = 0;
        }

        //ahora verificamos si el monto de acuenta es > 0, entoces registramos en la tabla abonos
        if ($request->acuenta > 0) {
            try {
                $id_registro_abono = DB::table('abono')->insertGetId([
                    'monto' => $request->acuenta,
                    'cliente' => $request->id_cliente,
                    'fecha' => Carbon::now(),
                    'recepcionista' => $nombreUsuario,
                    'derecho_pago' => "Renovación"
                ]);
            } catch (\Throwable $th) {
                //throw $th;
            }
        }


        if ($actualizar == 1) {
            return redirect()->route("cliente.index")->with("CORRECTO", "La renovación se realizó con exito");
        } else {
            return redirect()->route("cliente.index")->with("INCORRECTO", "Error, intente nuevamente");
        }
    }

    public function datosCliente($id)
    {
        $datos = DB::select("select * from cliente where id_cliente=?", [$id]);

        //mas datos para mostrar el calendario
        $sql = DB::select("select date(desde) as 'desde', date(hasta) as 'hasta' from cliente where tipo_usuario='cliente' and id_cliente=?", [
            $id
        ]);

        $asistencias = DB::select("select *, DATE_FORMAT(fecha_hora, '%Y-%m-%d') as fecha,DATE_FORMAT(fecha_hora, '%h:%i:%s %p') as hora from asistencia where id_cliente=?", [
            $id
        ]);

        foreach ($sql as $event) {
            $entrada = $event->desde;
            $salida = $event->hasta;
        }

        return view("vistas/cliente/show", compact("datos"))->with("desde", $entrada)->with("hasta", $salida)->with("asistencias", $asistencias);
    }

    public function transaccionCliente($id)
    {
        $datos = DB::select("select * from cliente where id_cliente=?", [$id]);

        //consulta
        $abonos = DB::select("SELECT
        abono.id_abono,
        abono.monto,
        abono.cliente,
        abono.fecha,
        abono.recepcionista,
        abono.derecho_pago,
        cliente.tipo_usuario,
        membresia.nombre,
        membresia.categoria,
        cliente.pago,
        cliente.debe,
        membresia.precio,
        cliente.id_cliente,
        date(cliente.desde) as 'desde',
        date(cliente.hasta) as 'hasta'
        FROM
        abono
        INNER JOIN cliente ON abono.cliente = cliente.id_cliente
        INNER JOIN membresia ON cliente.id_membresia = membresia.id_membresia
        where cliente.id_cliente=$id
        ");

        return view("vistas/cliente/transacciones", compact("datos", "abonos"));
    }

    public function pagoCliente($id_cliente)
    {
        $datos = DB::select(" SELECT
        cliente.id_membresia,
        cliente.tipo_usuario,
        cliente.creado_por,
        cliente.usuario,
        cliente.pago,
        cliente.`password`,
        cliente.dni,
        cliente.debe,
        cliente.nombre,
        cliente.correo,
        cliente.telefono,
        cliente.direccion,
        date(cliente.desde)as 'desde',
        date(cliente.hasta)as 'hasta',
        cliente.DT,
        cliente.DA,
        cliente.DR,
        cliente.foto,
        membresia.nombre AS nomMem,
        membresia.precio,
        cliente.id_cliente
        FROM cliente INNER JOIN membresia ON cliente.id_membresia = membresia.id_membresia where id_cliente=$id_cliente ");

        return view("vistas/cliente/pago", compact("datos"));
    }
}
