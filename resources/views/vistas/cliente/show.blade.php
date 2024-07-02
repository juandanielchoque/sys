@extends('layouts/app')
@section('titulo', 'Datos del cliente')
{{-- full calendar --}}
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: "es",
            events: [
                @foreach ($asistencias as $asistencia)
                    {
                        title: '{{ $asistencia->hora }}',
                        start: '{{ $asistencia->fecha }}',
                    },
                @endforeach
            ],
            visibleRange: {
                start: '{{ $desde }}',
                end: '{{ $hasta }} 23:59:59'
            },
            scrollTime: '{{ $desde }}',
            validRange: {
                start: '{{ $desde }}',
                end: '{{ $hasta }} 23:59:59'
            },
        });
        calendar.render();
    });
</script>

<style>
    #calendar {
        height: 60vh;
    }

    td:has(.fc-event) {
        background-color: rgb(231, 238, 243);
    }

    .evento {
        background: rgb(0, 166, 39) !important;
        color: white !important;
    }

    h1 {
        text-align: center;
        padding: 10px;
        padding-bottom: 0;
        font-size: 32px;
        font-weight: bold;
    }

    .page-content {
        display: flex;
        justify-content: center;
        flex-direction: column;
        align-items: center;
        align-content: center;
    }

    .block {
        background: rgb(236, 236, 236);
    }

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


    <h4 class="text-center text-secondary">ACTUALIZAR DATOS DEL CLIENTE</h4>


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
                    <div class="fl-flex-label mb-4 col-12 col-lg-6">
                        <input type="number" name="dni" class="input input__text" id="dni" placeholder="Dni *"
                            value="{{ old('dni', $item->dni) }}">
                        @error('dni')
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
                        <a href="{{ route('cliente.index') }}" class="btn btn-rounded btn-secondary m-2">Atras</a>
                        <button type="submit" class="btn btn-rounded btn-primary">Modificar</button>
                    </div>
                </div>

            </form>



        </div>
    @endforeach
    <hr>
    <div class="col-12 col-sm-12">
        <div id='calendar'></div>
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
                },
                error: function(data) {

                }
            })
        }


        let membresia = document.getElementById("membresia")
        let desde = document.getElementById("desde")
        membresia.addEventListener("change", consultar)
        desde.addEventListener("change", consultar)
    </script>

    <script>
        window.onload = function() {
            pintar();
        }
        document.getElementById("calendar").addEventListener("click", pintar);

        function pintar() {
            let td = document.querySelectorAll(".fc-event")
            td.forEach(function(el) {
                el.parentNode.parentNode.parentNode.parentNode.className = "evento"
            });
        }
    </script>

@endsection
