@extends('layouts/app')
@section('titulo', 'registrar usuario')

@section('content')
    <style>
        .block {
            background: rgb(236, 236, 236);
        }
    </style>

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


    <h4 class="text-center text-secondary">BIENVENIDO, REGISTRA TU PAGO</h4>

    <div class="mb-0 col-12 bg-white p-5">
        <!-- Modal -->
        @foreach ($datos as $key => $item2)
            <div class="row mb-4">
                <h5 class="alert alert-primary">Datos del cliente</h5>
                <input type="hidden" name="idcliente" value="{{ $item2->id_cliente }}">
                <div class="fl-flex-label mb-4 col-12 col-lg-4">
                    <input readonly type="number" name="dni" class="input input__text" id="dni" placeholder="Dni *"
                        value="{{ old('dni', $item2->dni) }}">
                    @error('dni')
                        <small class="error error__text">{{ $message }}</small>
                    @enderror
                </div>

                <div class="fl-flex-label mb-4 col-12 col-lg-4">
                    <input readonly type="text" name="usuario" class="input input__text" placeholder="Usuario *"
                        value="{{ old('usuario', $item2->usuario) }}">
                    @error('usuario')
                        <small class="error error__text">{{ $message }}</small>
                    @enderror
                </div>
                <div class="fl-flex-label mb-4 col-12 col-lg-4">
                    <input readonly type="text" name="nombre" class="input input__text" id="nombre"
                        placeholder="Nombres y Apellidos *" value="{{ old('nombre', $item2->nombre) }}">
                    @error('nombre')
                        <small class="error error__text">{{ $message }}</small>
                    @enderror
                </div>
                <div class="fl-flex-label mb-4 col-12 col-lg-4">
                    <input readonly type="email" name="correo" class="input input__text" placeholder="Correo *"
                        value="{{ old('correo', $item2->correo) }}">
                    @error('correo')
                        <small class="error error__text">{{ $message }}</small>
                    @enderror
                </div>
                <div class="fl-flex-label mb-4 col-12 col-lg-4">
                    <input readonly type="text" name="telefono" class="input input__text" placeholder="Telefono"
                        value="{{ old('telefono', $item2->telefono) }}">
                </div>
                <div class="fl-flex-label mb-4 col-12 col-lg-4">
                    <input readonly type="text" name="direccion" class="input input__text" placeholder="Dirección"
                        value="{{ old('direccion', $item2->direccion) }}">
                </div>

            </div>


            <form action="{{ route('pagos.store') }}" class="formulario" method="POST">
                @csrf
                <h5 class="alert alert-primary">Datos del pago</h5>
                <input type="hidden" name="idcliente" value="{{ $item2->id_cliente }}">
                <div class="row">
                    <div class="fl-flex-label mb-4 col-6">
                        <label class="text-left">Membresia</label>
                        <input type="text" name="nombre" class="input input__text block" value="{{ $item2->nomMem }}"
                            id="nombre" readonly>
                        @error('nombre')
                            <small class="error error__text">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="fl-flex-label mb-4 col-6">
                        <label class="text-left">Precio de la membresia</label>
                        <input type="text" name="" class="input input__text block danger"
                            value="{{ $item2->precio }}" readonly>
                    </div>

                    <div class="fl-flex-label mb-4 col-6">
                        <label class="text-left">Debe antes</label>
                        <input type="text" name="precio"
                            class="input input__text block danger precio{{ $key }}" value="{{ $item2->debe }}"
                            id="precio" readonly>
                        @error('precio')
                            <small class="error error__text">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="fl-flex-label mb-4 col-6">
                        <label class="text-left">Paga con</label>
                        <input type="text" name="pagacon" class="input input__text danger pagacon" value="0"
                            id="pagacon">
                        @error('pagacon')
                            <small class="error error__text">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="fl-flex-label mb-4 col-6">
                        <label class="text-left">Debe ahora</label>
                        <input type="text" name="debe" class="input input__text danger debe{{ $key }}"
                            value="{{ $item2->debe }}" id="debe">
                        @error('debe')
                            <small class="error error__text">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="text-right mt-0">
                        <a href="{{ route('cliente.index') }}" class="btn btn-rounded btn-secondary m-2">Atras</a>
                        <button type="submit" class="btn btn-rounded btn-primary">Guardar</button>
                    </div>
                </div>

            </form>
        @endforeach
    </div>

    <script>
        let pagacon = document.querySelectorAll(".pagacon");
        pagacon.forEach(function(e, index) {
            e.addEventListener("input", function(el) {
                let precio = document.querySelector(`.precio${index}`).value
                let pagacon = el.target.value
                let debe = precio - pagacon
                if (debe < 0) {
                    debe = 0;
                }
                document.querySelector(`.debe${index}`).value = debe
                console.log(debe)
            })
        });
    </script>


@endsection
