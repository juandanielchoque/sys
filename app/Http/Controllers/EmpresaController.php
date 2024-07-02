<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmpresaController extends Controller
{
    public function datos()
    {
        $sql = DB::select(" select * from empresa ");
        return view("vistas/empresa.empresa", compact("sql"));
    }

    public function editar(Request $request)
    {
        try {
            $sql = DB::update(" update empresa set nombre=?, ubicacion=?, telefono=?, correo=? where id_empresa=? ", [
                $request->nombre,
                $request->ubicacion,
                $request->telefono,
                $request->correo,
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
            "foto" => "required|mimes:jpg,jpeg,png"
        ]);

        $logoNombre = DB::select("select * from empresa limit 1");
        $logoAntiguo = $logoNombre[0]->foto;
        $ruta = public_path("foto/empresa/$logoAntiguo");
        //ahora primero eliminamos la foto antigua
        try {
            unlink($ruta);
        } catch (\Throwable $th) {
            //throw $th;
        }

        //ahora recogemos y almacenamos la imagen
        try {
            $foto = $request->file("foto");
            $nombreFoto = "logo" . "." . $foto->guessExtension();
            $ruta = public_path("foto/empresa/" . $nombreFoto);
            copy($foto, $ruta);
        } catch (\Throwable $th) {
            $nombreFoto = "";
        }

        //ahora actualizamos la BD con el nombre del archivo
        try {
            $sql = DB::update("update empresa set foto='$nombreFoto' ");
            if ($sql == 0) {
                $sql = 1;
            }
        } catch (\Throwable $th) {
            $sql = 0;
        }

        if ($sql == 1) {
            return back()->with("CORRECTO", "Imagen modificado correctamente");
        } else {
            return back()->with("INCORRECTO", "Error al modificar");
        }


        // try {
        //     $foto = file_get_contents($_FILES['foto']['tmp_name']);
        // } catch (\Throwable $th) {
        //     $foto = "";
        // }
        // if ($foto == "") {
        //     return back()->with("AVISO", "Debe seleccionar una imagen ...!");
        // }

        // try {
        //     $sql = DB::update(" update empresa set foto=? where id_empresa=? ", [
        //         $foto,
        //         $request->id
        //     ]);
        //     if ($sql == 0) {
        //         $sql = 1;
        //     }
        // } catch (\Throwable $th) {
        //     $sql = 0;
        // }
        // if ($sql == 1) {
        //     return back()->with("CORRECTO", "Imagen modificado correctamente");
        // } else {
        //     return back()->with("INCORRECTO", "Error al modificar");
        // }
    }

    public function eliminarImg($id)
    {

        // obtenemos los datos de la empresa->foto para posteriormente eliminar del servidor
        $fotoAntiguo = DB::select("select * from empresa");
        $nombreFoto = $fotoAntiguo[0]->foto;
        $ruta = public_path("foto/empresa/$nombreFoto");
        try {
            unlink($ruta);
        } catch (\Throwable $th) {
            //throw $th;
        }

        //ahora actualizamos en campo foto en NULL
        try {
            $sql = DB::update("update empresa set foto='' ");
            if ($sql == 0) {
                $sql = 1;
            }
        } catch (\Throwable $th) {
            $sql = 0;
        }

        if ($sql == 1) {
            return back()->with("CORRECTO", "Imagen eliminado correctamente");
        } else {
            return back()->with("INCORRECTO", "Error al eliminar");
        }


        // try {
        //     $sql = DB::update(" update empresa set foto=null where id_empresa=? ", [
        //         $id
        //     ]);
        //     if ($sql == 0) {
        //         $sql = 1;
        //     }
        // } catch (\Throwable $th) {
        //     $sql = 0;
        // }
        // if ($sql == 1) {
        //     return back()->with("CORRECTO", "Imagen eliminado correctamente");
        // } else {
        //     return back()->with("INCORRECTO", "Error al eliminar");
        // }
    }
}
