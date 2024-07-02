@extends('layouts/app')
@section('titulo', 'registrar usuario')

@section('content')

    <style>
        .block {
            background: rgb(236, 236, 236);
        }
    </style>

    {{-- notificaciones --}}


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


    <h4 class="text-center text-secondary">REGISTRO DE CLIENTES</h4>

    <div class="mb-0 col-12 bg-white p-5">
        <form action="{{ route('cliente.store') }}" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="row">
                <div class="fl-flex-label mb-4 col-12 col-lg-6">
                    <label>Membresia</label>
                    <select class="input input__select" name="membresia" id="membresia">
                        <option value="">Seleccionar Membresia</option>
                        @foreach ($membresia as $item)
                            <option {{old('membresia') == $item->id_membresia ? 'selected' : ''}} value="{{ $item->id_membresia }}">{{ $item->nombre }}</option>
                        @endforeach
                    </select>
                    @error('membresia')
                        <small class="error error__text">{{ $message }}</small>
                    @enderror
                </div>

                <div class="fl-flex-label mb-4 col-12 col-lg-6">
                    <label>Precio</label>
                    <input type="text" name="precio" class="input input__text block" value="{{ old('precio', 0) }}"
                        id="precio" readonly>
                    @error('precio')
                        <small class="error error__text">{{ $message }}</small>
                    @enderror
                </div>

                <div class="fl-flex-label mb-4 col-12 col-lg-6">
                    <label>Desde</label>
                    <input type="date" name="desde" class="input input__text" value="{{ old('desde') }}"
                        id="desde">
                    @error('desde')
                        <small class="error error__text">{{ $message }}</small>
                    @enderror
                </div>

                <div class="fl-flex-label mb-4 col-12 col-lg-6">
                    <label>Hasta</label>
                    <input type="date" name="hasta" class="input input__text block" value="{{ old('hasta') }}"
                        id="hasta" readonly>
                    @error('hasta')
                        <small class="error error__text">{{ $message }}</small>
                    @enderror
                </div>

                <div class="fl-flex-label mb-4 col-12 col-lg-6">
                    <label>N° de entradas ( <small>Recuerda los dias domingo no cuenta</small> )</label>
                    <input type="number" name="dias" class="input input__text block" value="{{ old('dias', 0) }}"
                        id="dias" readonly>
                    @error('dias')
                        <small class="error error__text">{{ $message }}</small>
                    @enderror
                </div>

                <div class="fl-flex-label mb-4 col-12 col-lg-6">
                    <input type="number" name="dni" class="input input__text" id="dni" placeholder="Dni *"
                        value="{{ old('dni') }}">
                    @error('dni')
                        <small class="error error__text">{{ $message }}</small>
                    @enderror
                </div>

                <div class="fl-flex-label mb-4 col-12 col-lg-6">
                    <input type="text" name="usuario" class="input input__text" placeholder="Usuario *"
                        value="{{ old('usuario') }}">
                    @error('usuario')
                        <small class="error error__text">{{ $message }}</small>
                    @enderror
                </div>

                <div class="fl-flex-label mb-4 col-12 col-lg-6">
                    <input type="password" name="password" class="input input__text" placeholder="Contraseña *"
                        value="{{ old('password') }}">
                    @error('password')
                        <small class="error error__text">{{ $message }}</small>
                    @enderror
                </div>


                <div class="fl-flex-label mb-4 col-12 col-lg-6">
                    <input type="text" name="nombre" class="input input__text" id="nombre"
                        placeholder="Nombres y Apellidos *" value="{{ old('nombre') }}">
                    @error('nombre')
                        <small class="error error__text">{{ $message }}</small>
                    @enderror
                </div>
                <div class="fl-flex-label mb-4 col-12 col-lg-6">
                    <input type="email" name="correo" class="input input__text" placeholder="Correo *"
                        value="{{ old('correo') }}">
                    @error('correo')
                        <small class="error error__text">{{ $message }}</small>
                    @enderror
                </div>
                <div class="fl-flex-label mb-4 col-12 col-lg-6">
                    <input type="text" name="telefono" class="input input__text" placeholder="Telefono"
                        value="{{ old('telefono') }}">
                </div>
                <div class="fl-flex-label mb-4 col-12 col-lg-6">
                    <input type="text" name="direccion" class="input input__text" placeholder="Dirección"
                        value="{{ old('direccion') }}">
                </div>

                <div class="fl-flex-label mb-4 col-12 col-lg-6">
                    <label>A cuenta (Ingrese el monto del adelanto)</label>
                    <input type="number" step="0.5" name="acuenta" class="input input__text" id="acuenta"
                        value="{{ old('acuenta') }}">
                    @error('acuenta')
                        <small class="error error__text">{{ $message }}</small>
                    @enderror
                </div>

                <div class="fl-flex-label mb-4 col-12 col-lg-6">
                    <label>Subir imagen</label>
                    <input type="file" name="foto" class="input form-control-file input__text"
                        value="{{ old('foto') }}">
                </div>

                {{-- <div class="fl-flex-label mb-4 col-12 col-lg-12">
                    <textarea class="input form-control-file input__text" name="comentario" placeholder="Comentarios"></textarea>
                </div> --}}



                <div class="text-right mt-0">
                    <a href="{{ route('cliente.index') }}" class="btn btn-rounded btn-secondary m-2">Atras</a>
                    <button type="submit" class="btn btn-rounded btn-primary">Guardar</button>
                </div>
            </div>

        </form>
    </div>


    <script>
        function consultar() {
            let membresia = document.getElementById("membresia").value
            let desde = document.getElementById("desde").value
            console.log(desde)


            var ruta = "{{ url('consultar/registro/cliente') }}/" + membresia + "/" + desde + "";
            $.ajax({
                url: ruta,
                type: "get",
                success: function(data) {
                    document.getElementById("hasta").value = data.respuesta
                    document.getElementById("dias").value = data.dias
                    document.getElementById("precio").value = data.precio
                    document.getElementById("acuenta").value = "0"
                },
                error: function(data) {

                }
            })
        }


        let membresia = document.getElementById("membresia")
        let desde = document.getElementById("desde")
        valorDesde = desde.value = new Date().toISOString().slice(0, 10);
        membresia.addEventListener("change", consultar)
        desde.addEventListener("change", consultar)


        //hacer una funcion que calcule que el valor del input a cuenta no sea mayor al precio
        let acuenta = document.getElementById("acuenta")
        acuenta.addEventListener("change", function() {
            let precio = parseInt(document.getElementById("precio").value)
            if (acuenta.value > precio) {
                acuenta.value = precio
            }
        })
    </script>


@endsection
