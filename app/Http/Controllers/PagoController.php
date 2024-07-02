<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PagoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "idcliente", "precio", "pagacon", "debe"
        ]);
        $nombreUsuario = Auth::user()->nombre;

        $sql = DB::insert('insert into pago (id_cliente,registrado_por,costo_total,paga_con) values (?,?,?,?)', [
            $request->idcliente, $nombreUsuario, $request->precio, $request->pagacon
        ]);

        $actualizarDebeCliente = DB::update("update cliente set debe='$request->debe' where id_cliente=$request->idcliente");

        //ahora verificamos si el monto de acuenta es > 0, entoces registramos en la tabla abonos
            try {
                $id_registro_abono = DB::table('abono')->insertGetId([
                    'monto' => $request->pagacon,
                    'cliente' => $request->idcliente,
                    'fecha' => Carbon::now(),
                    'recepcionista' => $nombreUsuario,
                    'derecho_pago' => "Matricula"
                ]);
            } catch (\Throwable $th) {
                //throw $th;
            }

        if ($sql == 1) {
            return back()->with("CORRECTO", "El pago se realizó con éxito");
        } else {
            return back()->with("INCORRECTO", "Error al realizar pago");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
