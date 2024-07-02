<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MembresiaController extends Controller
{

    public function index()
    {

        $datos = DB::select(" select * from membresia order by id_membresia desc ");

        return view("vistas/membresia/membresia", compact("datos"));
    }

    public function create()
    {
        return view("vistas/membresia/registrar");
    }

    public function store(Request $request)
    {
        $request->validate([
            "categoria" => "required",
            "nombre" => "required",
            "mes" => "required",
            "modo" => "required",
            "precio" => "required",
        ]);

        $verifificarDuplicidad = DB::select(" select count(*) as 'total' from membresia where (categoria='$request->categoria' and nombre='$request->nombre') ");
        if ($verifificarDuplicidad[0]->total >= 1) {
            return back()->with("AVISO", "El nombre y categoria de la Membresia ya existe");
        }

        try {
            $sql = DB::insert("insert into membresia(categoria,nombre,meses,modo,precio) values(?,?,?,?,?)", [
                $request->categoria,
                $request->nombre,
                $request->mes,
                $request->modo,
                $request->precio,
            ]);
        } catch (\Throwable $th) {
            $sql = 0;
        }
        if ($sql == 1) {
            return back()->with("CORRECTO", "Membresia registrado correctamente");
        } else {
            return back()->with("INCORRECTO", "Error al registrar");
        }
    }

    public function edit($id)
    {
        $sql = DB::select("select * from membresia where id_membresia=?", [
            $id
        ]);

        return view('vistas/membresia/actualizar', compact('sql'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            "categoria" => "required",
            "nombre" => "required",
            "mes" => "required",
            "modo" => "required",
            "precio" => "required",
        ]);

        $verifificarDuplicidad = DB::select(" select count(*) as 'total' from membresia where (categoria='$request->categoria' and nombre='$request->nombre') and id_membresia!=$id");
        if ($verifificarDuplicidad[0]->total >= 1) {
            return back()->with("AVISO", "El nombre y categoria de la Membresia ya existe");
        }


        try {
            $sql = DB::update("update membresia set categoria=?,nombre=?, meses=?, modo=?,precio=?  where id_membresia=?", [
                $request->categoria,
                $request->nombre,
                $request->mes,
                $request->modo,
                $request->precio,
                $id
            ]);
            if ($sql == 0) {
                $sql = 1;
            }
        } catch (\Throwable $th) {
            $sql = 0;
        }

        if ($sql == 1) {
            return back()->with("CORRECTO", "Membresia actualizado correctamente");
        } else {
            return back()->with("INCORRECTO", "Error al actualizar");
        }
    }


    public function destroy($id)
    {
        try {
            $sql = DB::delete("delete from membresia where id_membresia=?", [
                $id
            ]);
            if ($sql == 0) {
                $sql = 1;
            }
        } catch (\Throwable $th) {
            $sql = 0;
        }

        if ($sql == 1) {
            return back()->with("CORRECTO", "Membresia eliminado correctamente");
        } else {
            return back()->with("INCORRECTO", "Error al eliminar");
        }
    }
}
