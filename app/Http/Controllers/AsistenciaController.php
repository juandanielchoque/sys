<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class AsistenciaController extends Controller
{



    public function index()
    {
        $sql = DB::table('asistencia')
            ->join('cliente', 'asistencia.id_cliente', '=', 'cliente.id_cliente')
            ->select('asistencia.*', 'cliente.nombre')
            ->paginate(10);

        $cliente = DB::select(" select * from cliente where tipo_usuario='cliente' ");

        return view("vistas/asistencia/asistencia", compact("sql", "cliente"));
    }

    public function store(Request $request)
    {
        $request->validate([
            "txtdni" => "required"
        ]);
        $fecha_hora = date("Y-m-d H:i:s");
        $solofecha = date("Y-m-d");
        $nombreUsuario = Auth::user()->nombre;
        $diaActual = Carbon::now()->format('l');
        $buscarCliente = DB::select("select count(*) as 'total',id_cliente, date(desde) as desde,date(hasta)as 'hasta',DR from cliente where dni='$request->txtdni' and tipo_usuario='cliente' ");
        $ultimaEntrada = DB::select(" select max(date(fecha_hora)) as 'fecha_hora' from asistencia where asistencia.id_cliente=?  ", [
            $buscarCliente[0]->id_cliente
        ]);

        if ($buscarCliente[0]->total <= 0) {
            return back()->with("AVISO", "El DNI ingresado no existe");
        }
        if ($buscarCliente[0]->hasta . "23:59:59" < $fecha_hora) {
            return back()->with("INCORRECTO", "Su fecha de membresia venció el " . $buscarCliente[0]->hasta);
        }
        if ($diaActual == "sunday" or $diaActual == "Sunday") {
            return back()->with("AVISO", "Los DOMINGOS no puedes marcar tu asistencia");
        }
        //validar que la fecha de hoy sea mayor o igual a la fecha "desde" de la membresia
        if ($buscarCliente[0]->desde > $solofecha) {
            return back()->with("INCORRECTO", "Su fecha de membresia inicia el " . $buscarCliente[0]->desde);
        }

        $restarFecha = Carbon::parse($solofecha)->diffInDays(Carbon::parse($ultimaEntrada[0]->fecha_hora));
        if ($restarFecha < 1 and $ultimaEntrada[0]->fecha_hora != null) {
            return back()->with("INCORRECTO", "Solo puedes registrar tu asistencia 1 vez al dia");
        }

        if ($buscarCliente[0]->DR <= 0) {
            return back()->with("INCORRECTO", "ERROR, El cliente ya cumplió la membresia");
        }

        try {
            $sql = DB::insert(
                "insert into asistencia (id_cliente,fecha_hora,marcado_por) values (?, ?,?)",
                [
                    $buscarCliente[0]->id_cliente, $fecha_hora, $nombreUsuario
                ]
            );

            $actualizarDias = DB::update("update cliente set DA=(DA+1), DR=(DR-1) where id_cliente=?", [
                $buscarCliente[0]->id_cliente
            ]);

            //SI LAS FECHAS DE MEMBRESIA YA VENCIERON
            $actualizar = DB::update("UPDATE cliente set DT=0, DA=0, DR=0 where hasta < CURDATE()");
        } catch (\Throwable $th) {
            $sql = 0;
        }

        if ($sql == 1 and $actualizarDias == 1) {
            return back()->with("CORRECTO", "Asistencia Registrado correctamente");
        } else {
            return back()->with("INCORRECTO", "Error al registrar la asistencia");
        }
    }

    public function marcarQR()
    {

        $fecha_hora = date("Y-m-d H:i:s");
        $solofecha = date("Y-m-d");
        $nombreUsuario = Auth::user()->nombre;
        $idCliente = Auth::user()->id_cliente;
        $dni = Auth::user()->dni;
        $diaActual = Carbon::now()->format('l');
        $buscarCliente = DB::select("select count(*) as 'total',id_cliente, date(desde) as desde,date(hasta)as 'hasta',DR from cliente where dni='$dni' and tipo_usuario='cliente' ");
        $ultimaEntrada = DB::select(" select max(date(fecha_hora)) as 'fecha_hora' from asistencia where asistencia.id_cliente=?  ", [
            $buscarCliente[0]->id_cliente
        ]);

        if ($buscarCliente[0]->total <= 0) {
            return back()->with("AVISO", "El DNI ingresado no existe");
        }
        if ($buscarCliente[0]->hasta . "23:59:59" < $fecha_hora) {
            return back()->with("INCORRECTO", "Su fecha de membresia venció el " . $buscarCliente[0]->hasta);
        }
        if ($diaActual == "sunday" or $diaActual == "Sunday") {
            return back()->with("AVISO", "Los DOMINGOS no puedes marcar tu asistencia");
        }
        //validar que la fecha de hoy sea mayor o igual a la fecha "desde" de la membresia
        if ($buscarCliente[0]->desde > $solofecha) {
            return back()->with("INCORRECTO", "Su fecha de membresia inicia el " . $buscarCliente[0]->desde);
        }

        $restarFecha = Carbon::parse($solofecha)->diffInDays(Carbon::parse($ultimaEntrada[0]->fecha_hora));
        if ($restarFecha < 1 and $ultimaEntrada[0]->fecha_hora != null) {
            return back()->with("INCORRECTO", "Solo puedes registrar tu asistencia 1 vez al dia");
        }

        if ($buscarCliente[0]->DR <= 0) {
            return back()->with("INCORRECTO", "ERROR, El cliente ya cumplió la membresia");
        }

        try {
            $sql = DB::insert(
                "insert into asistencia (id_cliente,fecha_hora,marcado_por) values (?, ?,?)",
                [
                    $buscarCliente[0]->id_cliente, $fecha_hora, $nombreUsuario
                ]
            );

            $actualizarDias = DB::update("update cliente set DA=(DA+1), DR=(DR-1) where id_cliente=?", [
                $buscarCliente[0]->id_cliente
            ]);

            //SI LAS FECHAS DE MEMBRESIA YA VENCIERON
            $actualizar = DB::update("UPDATE cliente set DT=0, DA=0, DR=0 where hasta < CURDATE()");
        } catch (\Throwable $th) {
            $sql = 0;
        }

        if ($sql == 1 and $actualizarDias == 1) {
            return back()->with("CORRECTO", "Asistencia Registrado correctamente");
        } else {
            return back()->with("INCORRECTO", "Error al registrar la asistencia");
        }
    }
}
