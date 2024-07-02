<?php

namespace App\Jobs;

use App\Models\Asistencia;
use App\Events\AsistenciasActualizadas;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ActualizarTablaAsistencias implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        // Obtener la lista actualizada de asistencias desde la base de datos
        $asistencias = DB::select(" SELECT
        asistencia.*,
        cliente.nombre
        FROM
        asistencia
        INNER JOIN cliente ON asistencia.id_cliente = cliente.id_cliente ");

        // Emitir un evento en tiempo real para actualizar la tabla de asistencias en el frontend
        event(new AsistenciasActualizadas($asistencias));
    }
}
