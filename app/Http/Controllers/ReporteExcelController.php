<?php

namespace App\Http\Controllers;

use App\Exports\AsistenciaExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReporteExcelController extends Controller
{
    public function reporteAsistencia()
    {
        return Excel::download(new AsistenciaExport, 'asistencias.xlsx'); //csv
    }
}
