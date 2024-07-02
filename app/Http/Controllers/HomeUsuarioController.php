<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeUsuarioController extends Controller
{
    public function index()
    {
        return view('homeCliente');
    }

    public function verAsistencia()
    {
        $sql = DB::select("select date(desde) as 'desde', date(hasta) as 'hasta' from cliente where tipo_usuario='cliente' and id_cliente=?", [
            Auth::user()->id_cliente
        ]);

        $asistencias = DB::select("select *, DATE_FORMAT(fecha_hora, '%Y-%m-%d') as fecha,DATE_FORMAT(fecha_hora, '%h:%i:%s %p') as hora from asistencia where id_cliente=?", [
            Auth::user()->id_cliente
        ]);

        foreach ($sql as $event) {
            $entrada = $event->desde;
            $salida = $event->hasta;
        }

        return view('verAsistencia')->with("desde", $entrada)->with("hasta", $salida)->with("asistencias", $asistencias);
    }
}
