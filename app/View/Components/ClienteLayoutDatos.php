<?php
namespace App\View\Components;

use Illuminate\View\Component;

class ClienteLayoutDatos extends Component
{
    public $idCliente;

    public function __construct($idCliente)
    {
        $this->idCliente = $idCliente;
    }

    public function render()
    {
        return view('vistas.cliente.layout');
    }
}
