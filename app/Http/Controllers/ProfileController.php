<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActualizarPerfilUsuarioRequest;
use App\Http\Requests\ActualizarUsuarioRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function datos($id)
    {
        $sql = DB::select(" select * from cliente where id_cliente=$id ");
        return view("usuarioProfile", compact("sql"));
    }

    public function editar(Request $request)
    {
        $verifificarDuplicidad = DB::select(" select count(*) as 'total' from cliente where (usuario='$request->usuario' or dni='$request->dni') and id_cliente!=$request->id  ");
        if ($verifificarDuplicidad[0]->total >= 1) {
            return back()->with("AVISO", "El usuario o DNI ya está en uso");
        }
        try {
            $sql = DB::update(" update cliente set usuario=?, dni=?, nombre=?, correo=?, telefono=?, direccion=? where id_cliente=? ", [
                $request->usuario,
                $request->dni,
                $request->nombre,
                $request->correo,
                $request->telefono,
                $request->direccion,
                $request->id
            ]);
            if ($sql == 0) {
                $sql = 1;
            }
        } catch (\Throwable $th) {
            $sql = 0;
        }
        if ($sql == 1) {
            return back()->with("CORRECTO", "Datos modificado correctamente");
        } else {
            return back()->with("INCORRECTO", "Error al modificar");
        }
    }

    public function editarImg(Request $request)
    {

        $request->validate([
            "id" => "required",
            "foto" => "required|mimes:jpg,jpeg,png"
        ]);
        $id = $request->id;
        $foto = $request->file("foto");
        $imageSize = getimagesize($foto);
        if (!$imageSize || !in_array($imageSize['mime'], ['image/jpeg', 'image/png'])) {
            return back()->with("INCORRECTO", "Formato de imagen no permitido");
        }    
        $nombreFoto = "usuario-$id" . "." . $foto->guessExtension();


        //primero eliminamos la imagen anterior
        $consultaNombreFoto = DB::select("select foto from cliente where id_cliente=$id");
        $ruta = public_path("foto/usuario/" . $consultaNombreFoto[0]->foto);
        try {
            unlink($ruta);
        } catch (\Throwable $th) {
            //throw $th;
        }

        //modificamos la bd con la nueva imagen
        try {
            $actualizar = DB::update("update cliente set foto='$nombreFoto' where id_cliente=$id");
            if ($actualizar == 0) {
                $actualizar = 1;
            }
        } catch (\Throwable $th) {
            $actualizar = 0;
        }

        //registramos la nueva img en el servidor
        try {
            $url = public_path("foto/usuario/$nombreFoto");
            copy($foto, $url);
        } catch (\Throwable $th) {
            //throw $th;
        }



        if ($actualizar == 1) {
            return back()->with("CORRECTO", "Imagen modificado correctamente");
        } else {
            return back()->with("INCORRECTO", "Error al modificar");
        }
    }

    public function eliminarImg($id)
    {


        $buscarNomFoto = DB::select("select foto from cliente where id_cliente=$id ");
        $nomFoto = $buscarNomFoto[0]->foto;
        $ruta = public_path("foto/usuario/$nomFoto");

        //actualizamos la bd
        try {
            $sql = DB::update("update cliente set foto='' where id_cliente=$id ");
            if ($sql == 0) {
                $sql = 1;
            }
        } catch (\Throwable $th) {
            $sql = 0;
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
}
