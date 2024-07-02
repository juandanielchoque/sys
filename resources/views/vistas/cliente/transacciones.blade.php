@extends('layouts/app')

@section('titulo', 'Transacciones')
<style>
    .contenedor {
        position: relative;
    }

    .diasRestantes {
        width: 180px;
        display: flex;
        flex-direction: column;
        text-align: center;
        border: solid rgb(175, 175, 175) 1.5px;
        position: absolute;
        top: 0;
        right: 0;
        z-index: 9;
    }

    .dia {
        font-size: 34px;
        font-weight: bold;
        background: white;
    }
</style>

@section('content')

    {{-- notificaciones --}}

    @if (session('DUPLICADO'))
        <script>
            $(function notificacion() {
                new PNotify({
                    title: "DUPLICADO",
                    type: "warning",
                    text: "{{ session('DUPLICADO') }}",
                    styling: "bootstrap3"
                });
            });
        </script>
    @endif

    @if (session('CORRECTO'))
        <script>
            $(function notificacion() {
                new PNotify({
                    title: "CORRECTO",
                    type: "success",
                    text: "{{ session('CORRECTO') }}",
                    styling: "bootstrap3"
                });
            });
        </script>
    @endif

    @if (session('INCORRECTO'))
        <script>
            $(function notificacion() {
                new PNotify({
                    title: "INCORRECTO",
                    type: "error",
                    text: "{{ session('INCORRECTO') }}",
                    styling: "bootstrap3"
                });
            });
        </script>
    @endif

    @if (session('AVISO'))
        <script>
            $(function notificacion() {
                new PNotify({
                    title: "AVISO",
                    type: "error",
                    text: "{{ session('AVISO') }}",
                    styling: "bootstrap3"
                });
            });
        </script>
    @endif


    <h4 class="text-center text-secondary">TRANSACCIONES DEL CLIENTE</h4>

    @foreach ($datos as $item)
        <x-ClienteLayoutDatos :idCliente="$item->id_cliente" />
        <div class="mb-0 col-12 bg-white p-5 contenedor">
            <div class="d-flex diasRestantes">
                <p class="bg-primary p-2 m-0">CLASES RESTANTES:</p>
                <span class="dia">{{ $item->DR }}</span>
                @if ($item->debe > 0)
                    <p class="bg-danger p-1 m-0">Debe: {{ $item->debe }}</p>
                    <a href="{{ route('cliente.pagoCliente', $item->id_cliente) }}"
                        class="btn btn-sm btn-primary">Pagar</a>
                @else
                    <p class="bg-success p-1 m-0">Cliente al dia</p>
                @endif
            </div>
            <form action="{{ route('cliente.editarDatosCliente') }}" method="POST">
                @csrf
                <div class="row">
                    <input type="hidden" name="idcliente" value="{{ $item->id_cliente }}">
                    <div class="fl-flex-label mb-4 col-12 col-lg-4">
                        <input readonly type="number" name="dni" class="input input__text" id="dni"
                            placeholder="Dni *" value="{{ old('dni', $item->dni) }}">
                        @error('dni')
                            <small class="error error__text">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="fl-flex-label mb-4 col-12 col-lg-4">
                        <input readonly type="text" name="usuario" class="input input__text" placeholder="Usuario *"
                            value="{{ old('usuario', $item->usuario) }}">
                        @error('usuario')
                            <small class="error error__text">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="fl-flex-label mb-4 col-12 col-lg-4">
                        <input readonly type="text" name="nombre" class="input input__text" id="nombre"
                            placeholder="Nombres y Apellidos *" value="{{ old('nombre', $item->nombre) }}">
                        @error('nombre')
                            <small class="error error__text">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="fl-flex-label mb-4 col-12 col-lg-4">
                        <input readonly type="email" name="correo" class="input input__text" placeholder="Correo *"
                            value="{{ old('correo', $item->correo) }}">
                        @error('correo')
                            <small class="error error__text">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="fl-flex-label mb-4 col-12 col-lg-4">
                        <input readonly type="text" name="telefono" class="input input__text" placeholder="Telefono"
                            value="{{ old('telefono', $item->telefono) }}">
                    </div>
                    <div class="fl-flex-label mb-4 col-12 col-lg-4">
                        <input readonly type="text" name="direccion" class="input input__text" placeholder="Dirección"
                            value="{{ old('direccion', $item->direccion) }}">
                    </div>

                    {{-- <div class="text-right mt-0">
                        <a href="{{ route('cliente.index') }}" class="btn btn-rounded btn-secondary m-2">Atras</a>
                        <button type="submit" class="btn btn-rounded btn-primary">Modificar</button>
                    </div> --}}
                </div>

            </form>


            <h5 class="alert text-white bg-secondary">Transacciones</h5>

            <div class="card-block">
                <table id="example" class="display table table-striped" cellspacing="0" width="100%">
                    <thead class="table-primary">
                        <tr>
                            <th>Id</th>
                            <th>Tipo</th>
                            <th>Fecha ingreso</th>
                            <th>Fecha final</th>
                            <th>A cuenta</th>
                            <th>Saldo</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Derecho pago</th>
                            <th>Recepcion</th>
                            <th>Accion</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($abonos as $key => $item)
                            <tr>
                                <td>{{ $item->id_cliente }}</td>
                                <td>{{ $item->nombre }}</td>
                                <td>{{ $item->desde }}</td>
                                <td>{{ $item->hasta }}</td>
                                <td>{{ $item->monto }}</td>
                                <td>{{ $item->debe }}</td>
                                <td>{{ $item->precio }}</td>
                                <td>
                                    @if ($item->debe <= 0)
                                        <p class="badge bg-success">Pagado</p>
                                    @else
                                        <p class="badge bg-danger">Deuda</p>
                                    @endif
                                </td>
                                <td>
                                    <p class="badge bg-dark">{{ $item->derecho_pago }}</p>
                                </td>
                                <td>
                                    <p class="badge bg-secondary">{{ $item->recepcionista }}</p>
                                </td>
                                <td>
                                    @if ($item->debe > 0)
                                    <a href="{{ route('cliente.pagoCliente', $item->id_cliente) }}"
                                        class="btn btn-sm btn-primary">Abonar</a>
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


        </div>
    @endforeach

@endsection
