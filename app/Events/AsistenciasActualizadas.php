<?php

namespace App\Events;

use App\Models\Asistencia;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AsistenciasActualizadas
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $asistencias;

    public function __construct($asistencias)
    {
        $this->asistencias = $asistencias;
    }

    public function broadcastOn()
    {
        return ['asistencias-actualizadas'];
    }

    public function broadcastWith()
    {
        return [
            'asistencias' => $this->asistencias,
        ];
    }
}
