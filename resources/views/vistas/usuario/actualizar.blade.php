@extends('layouts/app')
@section('titulo', 'registrar usuario')

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


    <h4 class="text-center text-secondary">ACTUALIZAR USUARIO</h4>

    <div class="mb-0 col-12 bg-white p-5">
        @foreach ($sql as $item)
            <form action="{{ route('usuario.update', $item->id_cliente) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="fl-flex-label mb-4 col-12 col-lg-6">
                        <select class="input input__select" name="tipo">
                            <option value="">Seleccionar Tipo de usuario</option>
                            <option {{ $item->tipo_usuario == 'administrador' ? 'selected' : '' }} value="administrador">
                                Administrador
                            </option>
                            <option {{ $item->tipo_usuario == 'vendedor' ? 'selected' : '' }} value="vendedor">Vendedor
                            </option>
                        </select>
                        @error('tipo')
                            <small class="error error__text">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="fl-flex-label mb-4 col-12 col-lg-6">
                        <input type="text" name="usuario" class="input input__text" placeholder="Usuario *"
                            value="{{ old('usuario', $item->usuario) }}">
                        @error('usuario')
                            <small class="error error__text">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="fl-flex-label mb-4 col-12 col-lg-6">
                        <input type="number" name="dni" class="input input__text" id="dni" placeholder="Dni *"
                            value="{{ old('dni', $item->dni) }}">
                        @error('dni')
                            <small class="error error__text">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="fl-flex-label mb-4 col-12 col-lg-6">
                        <input type="text" name="nombre" class="input input__text" id="nombre"
                            placeholder="Nombres y Apellidos *" value="{{ old('nombre', $item->nombre) }}">
                        @error('nombre')
                            <small class="error error__text">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="fl-flex-label mb-4 col-12 col-lg-6">
                        <input type="email" name="correo" class="input input__text" placeholder="Correo *"
                            value="{{ old('correo', $item->correo) }}">
                        @error('correo')
                            <small class="error error__text">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="fl-flex-label mb-4 col-12 col-lg-6">
                        <input type="text" name="telefono" class="input input__text" placeholder="Telefono"
                            value="{{ old('telefono', $item->telefono) }}">
                    </div>
                    <div class="fl-flex-label mb-4 col-12 col-lg-6">
                        <input type="text" name="direccion" class="input input__text" placeholder="Dirección"
                            value="{{ old('direccion', $item->direccion) }}">
                    </div>

                    <div class="text-right mt-0">
                        <a href="{{ route('usuario.index') }}" class="btn btn-rounded btn-secondary m-2">Atras</a>
                        <button type="submit" class="btn btn-rounded btn-primary">Guardar</button>
                    </div>
                </div>

            </form>
        @endforeach
    </div>




@endsection
