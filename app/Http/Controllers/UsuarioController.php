<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{

    public function index()
    {

        $sql = DB::select(" select * from cliente where tipo_usuario<>'cliente' order by id_cliente desc ");

        return view("vistas/usuario/usuario", compact("sql"));
    }

    public function create()
    {
        return view("vistas/usuario/registrar");
    }

    public function store(Request $request)
    {
        $request->validate([
            "tipo" => "required",
            "usuario" => "required|unique:App\Models\Usuario,usuario",
            "password" => "required",
            "dni" => "required|unique:App\Models\Usuario,dni",
            "nombre" => "required",
            "correo" => "required|unique:App\Models\Usuario,correo",
            "foto" => "mimes:jpg,jpeg,png"
        ]);

        $verifificarDuplicidad = DB::select(" select count(*) as 'total' from cliente where (usuario='$request->usuario' or dni='$request->dni') ");
        if ($verifificarDuplicidad[0]->total >= 1) {
            return back()->with("AVISO", "El usuario o DNI ya está en uso");
        }


        $claveE = md5($request->password);
        try {
            $id = DB::table('cliente')->insertGetId([
                'tipo_usuario' => $request->tipo,
                'usuario' => $request->usuario,
                'password' => $claveE,
                'dni' => $request->dni,
                'nombre' => $request->nombre,
                'correo' => $request->correo,
                'telefono' => $request->telefono,
                'direccion' => $request->direccion
            ]);
        } catch (\Throwable $th) {
            $sql = 0;
        }


        //almacenamos la foto en servidor
        try {
            $foto = $request->file("foto");
            $nombreFoto = "usuario-$id" . "." . $foto->guessExtension();
            $ruta = public_path("foto/usuario/$nombreFoto");
            copy($foto, $ruta);
        } catch (\Throwable $th) {
            $nombreFoto = "";
        }


        //actualizamos el campo foto en la BD
        try {
            $actualizarCampoFoto = DB::update("update cliente set foto='$nombreFoto' where id_cliente=$id ");
        } catch (\Throwable $th) {
            $actualizarCampoFoto = 0;
        }


        if ($id >= 1) {
            return back()->with("CORRECTO", "Usuario registrado correctamente");
        } else {
            return back()->with("INCORRECTO", "Error al registrar");
        }
    }

    public function actualizarImagen(Request $request)
    {

        $request->validate([
            "foto" => "required|mimes:jpg,jpeg,png",
            "id" => "required"
        ]);
        $id = $request->id;
        $foto = $request->file("foto");
        $nombre = "usuario-" . $id . "." . $foto->guessExtension();

        //primero eliminamos la imagen anterior
        try {
            $ruta = public_path("foto/usuario/$request->nomFoto");
            unlink($ruta);
        } catch (\Throwable $th) {
            //throw $th;
        }


        //ahora modificamos con nueva imagen
        try {
            $sql = DB::update("update cliente set foto='$nombre' where id_cliente=$id ");
            if ($sql == 0) {
                $sql = 1;
            }
        } catch (\Throwable $th) {
            $sql = 0;
        }

        //ahora copiamos la imagenes al servidor
        try {
            $ruta = public_path("foto/usuario/$nombre");
            copy($foto, $ruta);
        } catch (\Throwable $th) {
        }





        if ($sql == 1) {
            return back()->with("CORRECTO", "Foto del perfil actualizado");
        } else {
            return back()->with("INCORRECTO", "Error al actualizar");
        }
    }

    public function eliminarImagen($id)
    {

        $buscarNomFoto = DB::select("select foto from cliente where id_cliente=$id ");
        $nomFoto = $buscarNomFoto[0]->foto;
        $ruta = public_path("foto/usuario/$nomFoto");

        //actualizamos la bd
        try {
            $sql = DB::update("update cliente set foto='' where id_cliente=$id ");
        } catch (\Throwable $th) {
            return back()->with("INCORRECTO", "No se ha podido actualizar la BD ");
        }

        //ahora eliminamos la img del servidor
        try {
            unlink($ruta);
        } catch (\Throwable $th) {
            return back()->with("INCORRECTO", "No se ha podido eliminar la Imagen del servidor ");
        }



        if ($sql == 1) {
            return back()->with("CORRECTO", "Foto del perfil eliminado");
        } else {
            return back()->with("INCORRECTO", "Error al eliminar");
        }
    }


    public function edit($id)
    {
        $sql = DB::select("select * from cliente where id_cliente=?", [
            $id
        ]);

        return view('vistas/usuario/actualizar', compact('sql'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            "tipo" => "required",
            "usuario" => "required",
            "dni" => "required",
            "nombre" => "required",
            "correo" => "required",
        ]);

        $verifificarDuplicidad = DB::select(" select count(*) as 'total' from cliente where (usuario='$request->usuario' or dni='$request->dni') and id_cliente!=$id");
        if ($verifificarDuplicidad[0]->total >= 1) {
            return back()->with("AVISO", "El usuario o DNI ya está en uso");
        }


        try {
            $sql = DB::update("update cliente set tipo_usuario=?,usuario=?, dni=?, nombre=?,correo=?,telefono=?, direccion=?  where id_cliente=?", [
                $request->tipo,
                $request->usuario,
                $request->dni,
                $request->nombre,
                $request->correo,
                $request->telefono,
                $request->direccion,
                $id
            ]);
            if ($sql == 0) {
                $sql = 1;
            }
        } catch (\Throwable $th) {
            $sql = 0;
        }

        if ($sql == 1) {
            return back()->with("CORRECTO", "Usuario actualizado correctamente");
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
            return back()->with("CORRECTO", "Usuario eliminado correctamente");
        } else {
            return back()->with("INCORRECTO", "Error al eliminar");
        }
    }
}
