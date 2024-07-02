@extends('layouts.app')

@section('content')
    <style>
        .block {
            background: rgb(236, 236, 236);
        }

        .danger {
            color: red !important;
            font-weight: bold;
        }
    </style>
    <!--.side-menu-->
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

    <h2 class="text-center text-secondary pb-2">PANEL DE CONTROL</h2>

    <div class="container-fluid text-center">
        <div class="row col-12">

            <div class="col-12 col-sm-7 col-md-9">
                <!--.col-->
                <div class="col-12">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-lg-3">
                            <article class="statistic-box red">
                                <div>
                                    <div class="number text-light">{{ $totalMembresia }}</div>
                                    <div class="caption">
                                        <div>MEMBRESIAS</div>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <!--.col-->
                        <div class="col-12 col-sm-6 col-lg-3">
                            <article class="statistic-box purple">
                                <div>
                                    <div class="number text-light">{{ $totalCliente }}</div>
                                    <div class="caption">
                                        <div>CLIENTES REGISTRADOS</div>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <!--.col-->
                        <div class="col-12 col-sm-6 col-lg-3">
                            <article class="statistic-box green">
                                <div>
                                    <div class="number text-light">{{ $totalUsuario }}</div>
                                    <div class="caption">
                                        <div>USUARIOS DEL SISTEMA</div>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <!--.col-->
                        <div class="col-12 col-sm-6 col-lg-3">
                            <article class="statistic-box yellow">
                                <div>
                                    <div class="number text-light">{{ $totalAsistencia }}</div>
                                    <div class="caption">
                                        <div>ASISTENCIAS DE HOY</div>
                                    </div>
                                </div>
                            </article>
                        </div>

                        <!--.col-->
                    </div>
                    <!--.row-->
                </div>
                <!--.col-->
                <div class="container">
                    <h2>Registra tu Asistencia</h2>
                    <form action="{{ route('asistencia.store') }}" method="POST">
                        @csrf
                        <div class="form-group row col-12">
                            @error('txtdni')
                                <div class="alert alert-danger">{{ $errors->first('txtdni') }}</div>
                            @enderror

                            @if (session('CORRECTO'))
                                <div class="alert alert-success">{{ session('CORRECTO') }}</div>
                            @endif

                            @if (session('INCORRECTO'))
                                <div class="alert alert-danger">{{ session('INCORRECTO') }}</div>
                            @endif

                            @if (session('AVISO'))
                                <div class="alert alert-warning">{{ session('AVISO') }}</div>
                            @endif


                            <div class="col-12 col-md-8 col-lg-9 mb-3">
                                <input type="number" class="form-control p-4 border-secondary"
                                    placeholder="Ingrese el DNI del cliente" name="txtdni" required>
                            </div>
                            <div class="col-12 col-md-4 col-lg-3" style="min-width: 200px">
                                <button type="submit" class="form-control btn btn-primary p-4">Marcar
                                    Asistencia</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!--.col-->
            </div>

            <div class="col-12 col-sm-5 col-md-3 overflow-scroll" style="height: 60vh">
                <table class="table mb-2">
                    <thead class="thead-dark">
                        <tr>
                            <th colspan="2" class="text-center bg-primary col-12" scope="col">Miembros por renovar
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($miembrosPorRenovar as $item)
                            @if ($item->diferencia_fechas <= 7 && $item->diferencia_fechas > 0)
                                <tr>
                                    <td colspan="2">
                                        <div class="user-card-row">
                                            <div class="tbl-row">
                                                <div class="tbl-cell tbl-cell-photo">
                                                    <a href="#">
                                                        @if ($item->foto != '')
                                                            <img src="data:image/jpg;base64,{{ base64_encode($item->foto) }}"
                                                                alt="">
                                                        @else
                                                            <img src="{{ asset('img-inicio/user.jpg') }}" alt="">
                                                        @endif

                                                    </a>
                                                </div>
                                                <div class="tbl-cell">
                                                    <p class="text-dark font-weight-bold"><a
                                                            href="{{ route('cliente.show', $item->id_cliente) }}"
                                                            class="text-dark">{{ $item->nombre }}</a>
                                                    </p>
                                                    <p class="user-card-row-status">{{ $item->modo }}</p>
                                                </div>
                                                <div class="tbl-cell tbl-cell-action"><b>
                                                        Quedan {{ $item->diferencia_fechas }}
                                                        dias
                                                    </b>
                                                    <p>
                                                    </p>
                                                    <p class="text-danger font-weight-bold">S/. {{ $item->precio }} .00</p>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endif

                            @if ($item->diferencia_fechas <= 0 && $item->diferencia_fechas >= -10)
                                <tr style="background:#FFDADA;">
                                    <td colspan="2">
                                        <div class="user-card-row">
                                            <div class="tbl-row">
                                                <div class="tbl-cell tbl-cell-photo">
                                                    <a href="#">
                                                        @if ($item->foto != '')
                                                            <img src="data:image/jpg;base64,{{ base64_encode($item->foto) }}"
                                                                alt="">
                                                        @else
                                                            <img src="{{ asset('img-inicio/user.jpg') }}" alt="">
                                                        @endif

                                                    </a>
                                                </div>
                                                <div class="tbl-cell">
                                                    <p class="text-dark font-weight-bold"><a
                                                            href="{{ route('cliente.show', $item->id_cliente) }}"
                                                            class="text-dark">{{ $item->nombre }}</a>
                                                    </p>
                                                    <p class="user-card-row-status">{{ $item->modo }}</p>
                                                </div>
                                                <div class="tbl-cell tbl-cell-action"><b>
                                                        Caducado hace {{ abs($item->diferencia_fechas) }} días
                                                    </b>
                                                    <p>
                                                    </p>
                                                    <p class="text-danger font-weight-bold">S/. {{ $item->precio }} .00</p>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endif

                            {{-- @if ($item->diferencia_fechas < -10)
                                <tr style="background:#FFDADA;">
                                    <td colspan="2">
                                        <div class="user-card-row">
                                            <div class="tbl-row">
                                                <div class="tbl-cell tbl-cell-photo">
                                                    <a href="#">
                                                        @if ($item->foto != '')
                                                            <img src="data:image/jpg;base64,{{ base64_encode($item->foto) }}"
                                                                alt="">
                                                        @else
                                                            <img src="{{ asset('img-inicio/user.jpg') }}" alt="">
                                                        @endif

                                                    </a>
                                                </div>
                                                <div class="tbl-cell">
                                                    <p class="text-dark font-weight-bold"><a
                                                            href="{{ route('cliente.show', $item->id_cliente) }}"
                                                            class="text-dark">{{ $item->nombre }}</a>
                                                    </p>
                                                    <p class="user-card-row-status">{{ $item->modo }}</p>
                                                </div>
                                                <div class="tbl-cell tbl-cell-action"><b>
                                                        Archivado hace {{ abs($item->diferencia_fechas + 10) }} días
                                                    </b>
                                                    <p>
                                                    </p>
                                                    <p class="text-danger font-weight-bold">S/. {{ $item->precio }} .00</p>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endif --}}
                        @endforeach

                    </tbody>
                </table>

                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th colspan="2" class="text-center bg-info" scope="col">Cuentas por cobrar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cuentasPorCobrar as $key => $item2)
                            @if ($item2->diferencia_fechas <= 15 && $item2->diferencia_fechas > 0)
                                <tr>
                                    <td colspan="2">
                                        <div class="user-card-row">
                                            <div class="tbl-row">
                                                <div class="tbl-cell tbl-cell-photo">
                                                    <a href="#">
                                                        @if ($item2->foto != '')
                                                            <img src="data:image/jpg;base64,{{ base64_encode($item2->foto) }}"
                                                                alt="">
                                                        @else
                                                            <img src="{{ asset('img-inicio/user.jpg') }}" alt="">
                                                        @endif

                                                    </a>
                                                </div>
                                                <div class="tbl-cell">
                                                    <p class="text-dark font-weight-bold"><a
                                                            href="{{ route('cliente.pagoCliente', $item2->id_cliente) }}">{{ $item2->nombre }}</a>
                                                    </p>
                                                    <p class="user-card-row-status">{{ $item2->modo }}</p>
                                                </div>
                                                <div class="tbl-cell tbl-cell-action"><b>{{ $item2->diferencia_fechas }}
                                                        dias</b>
                                                    <p>
                                                    </p>
                                                    <p class="text-danger font-weight-bold">S/. {{ $item2->debe }} .00
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>






        </div>
    </div>

    <!--.container-fluid-->
    <!--.page-content-->

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
    <script>
        const scanButton = document.getElementById('scanButton');
        scanButton.addEventListener('click', () => {
            // Abre el escáner
            const scanner = new window.Scanner();
            scanner.scan((result) => {
                // Maneja el resultado del escaneo
                console.log(result);
            });
        });
    </script>

    </body>
@endsection

@section('content-vendedor')
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
    <button id="scanButton" class="btn btn-primary">Escanear</button>
@endsection
