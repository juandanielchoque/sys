<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportePdfController extends Controller
{
    public function reporteAsistencia(Request $request)
    {
        $id = $request->cliente;
        $datos = DB::select(" SELECT
        asistencia.fecha_hora,
        asistencia.marcado_por,
        cliente.nombre,
        cliente.id_cliente
        FROM
        asistencia
        inner JOIN cliente ON asistencia.id_cliente = cliente.id_cliente
        WHERE cliente.id_cliente=$id
        order by fecha_hora asc ");
        $pdf = \App::make('dompdf.wrapper');
        //$pdf->setPaper('a4', 'landscape');//FORMATO HORIZONTAL
        $pdf->loadView('vistas/reporte-pdf/asistencia', compact('datos', $datos));
        return $pdf->stream("reporte de asistencias - $id");
    }
}
