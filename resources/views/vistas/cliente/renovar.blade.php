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


    <h4 class="text-center text-secondary">BIENVENIDO, GRACIAS POR RENOVAR</h4>

    <div class="mb-0 col-12 bg-white p-5">
        {{-- <div class="alert alert-danger"><b>ADVERTENCIA:</b>Si el cliente ya registró su asistencia <b>al menos una vez</b>,
            no modique; esto puede alterar la informacion en la BD</div> --}}
        @foreach ($sql as $item)
            <form action="{{ route('cliente.renovar', $item->id_cliente) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <input type="hidden" name="id_cliente" value="{{ $item->id_cliente }}">
                    <div class="fl-flex-label mb-4 col-12 col-lg-6">
                        <label>Tipo de membresia</label>
                        <select class="input input__select" name="membresia" id="membresia">
                            <option value="">Seleccionar Membresia</option>
                            @foreach ($membresia as $item2)
                                <option {{ $item2->id_membresia == $item->id_membresia ? 'selected' : '' }}
                                    value="{{ $item2->id_membresia }}">{{ $item2->nombre }}</option>
                            @endforeach
                        </select>
                        @error('membresia')
                            <small class="error error__text">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="fl-flex-label mb-4 col-12 col-lg-6">
                        <label>Precio</label>
                        <input type="text" name="precio" class="input input__text block"
                            value="{{ old('precio', $item->debe) }}" id="precio" readonly>
                        @error('precio')
                            <small class="error error__text">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="fl-flex-label mb-4 col-12 col-lg-6">
                        <label>Desde</label>
                        <input type="date" name="desde" class="input input__text" value="{{ $hasta }}"
                            id="desde" min="{{ $hasta }}">
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

                    <div hidden class="fl-flex-label mb-4 col-12 col-lg-6">
                        <label>N° de entradas que le quedan al cliente Antes<b>{{ $item->DR }}</b></label>
                        <input type="number"value="{{ $item->DR }}" id="diasAntes" readonly>
                    </div>

                    <div class="fl-flex-label mb-4 col-12 col-lg-6">
                        <label>N° de entradas que le quedaban al cliente anteriormente <b>{{ $item->DR }}</b></label>
                        <input type="number" name="dias" class="input input__text block"
                            value="{{ old('dias', $item->DT) }}" id="dias" readonly>
                        @error('dias')
                            <small class="error error__text">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="fl-flex-label mb-4 col-12 col-lg-6">
                        <label>Monto que debía el cliente anteriormente S/.</label>
                        <input type="text" name="debe" class="input input__text block"
                            value="{{ old('debe', $item->debe) }}" id="debe"
                            style="color: red!important;font-weight: bold" readonly>
                        @error('debe')
                            <small class="error error__text">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="fl-flex-label mb-4 col-12 col-lg-12">
                        <label>Total a pagar (precio+debe)</label>
                        <input type="text" name="total" class="input input__text block"
                            value="{{ old('total', $item->debe) }}" id="total"
                            style="color: red!important;font-weight: bold" readonly>
                        @error('total')
                            <small class="error error__text">{{ $message }}</small>
                        @enderror
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
                        <label>Pago restante (total a pagar - a cuenta)</label>
                        <input type="text" name="pagoRestante" class="input input__text block" value=""
                            id="pagoRestante" style="color: red!important;font-weight: bold" readonly>
                        @error('pagoRestante')
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
                    document.getElementById("dias").value = (parseInt(document.getElementById("diasAntes")
                        .value) + data.dias)
                    document.getElementById("precio").value = data.precio
                    document.getElementById("total").value = (parseInt(document.getElementById("precio")
                        .value) + parseInt(document.getElementById("debe").value))
                    document.getElementById("acuenta").value = "0"
                    document.getElementById("pagoRestante").value = "0"
                },
                error: function(data) {

                }
            })
        }


        let membresia = document.getElementById("membresia")
        let desde = document.getElementById("desde")
        //valorDesde = desde.value = new Date().toISOString().slice(0, 10);
        membresia.addEventListener("change", consultar)
        window.addEventListener("load", consultar)
        desde.addEventListener("change", consultar)


        //hacer una funcion que calcule que el valor del input a cuenta no sea mayor al total a pagar
        let acuenta = document.getElementById("acuenta")
        acuenta.addEventListener("blur", pagoACuenta)
        acuenta.addEventListener("keyup", pagoACuenta)

        function pagoACuenta() {
            let total = parseInt(document.getElementById("total").value)
            if (acuenta.value > total) {
                acuenta.value = total
            }

            document.getElementById("pagoRestante").value = total - acuenta.value
        }
    </script>

@endsection
