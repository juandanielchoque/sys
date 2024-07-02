<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class AsistenciaExport implements FromView
{
    public function view(): View
    {
        $asistencia = DB::select(" SELECT
        asistencia.id_asistencia,
        asistencia.fecha_hora,
        asistencia.marcado_por,
        cliente.nombre
        FROM
        asistencia
        INNER JOIN cliente ON asistencia.id_cliente = cliente.id_cliente ");
        return view("vistas/reporte-excel/asistencia", ["asistencia" => $asistencia]);
    }
}
