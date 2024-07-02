<div class="d-flex gap-1 w-100 px-2">
    <a href="{{ route('cliente.datosCliente', ['id' => $idCliente]) }}" class="btn {{ Request::is('clienteDatos*') ? 'btn-bg-primary' : 'btn-secondary' }}">DATOS</a>
    <a href="{{ route('cliente.transaccionCliente', ['id' => $idCliente]) }}" class="btn {{ Request::is('clienteTransaccion*') ? 'btn-bg-primary' : 'btn-secondary' }}">TRANSACCIONES</a>
</div>
