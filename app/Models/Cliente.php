<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Cliente extends Authenticatable
{
    use HasFactory;

    use Notifiable;
    public $table = 'cliente';
    public $primaryKey = 'id_cliente';
    public $timestamps = false;
    public $fillable = [
        'membresia',
        'creado_por',
        'usuario',
        'password',
        'dni',
        'nombre',
        'correo',
        'telefono',
        'desde',
        'hasta',
        'DT',
        'DA',
        'DR',

    ];
}
