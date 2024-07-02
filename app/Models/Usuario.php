<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    use HasFactory;
    public $table = 'cliente';
    public $primaryKey = 'id_cliente';
    public $timestamps = false;
    public $fillable = [
        'membresia',
        'tipo_usuario',
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
