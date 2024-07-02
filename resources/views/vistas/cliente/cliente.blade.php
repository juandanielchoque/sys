@extends('layouts/app')
@section('titulo', 'clientes')

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



    <h4 class="text-center text-secondary">LISTA DE CLIENTES REGISTRADOS</h4>
    <div class="pb-1 pt-2">
        <a href="{{ route('cliente.create') }}" class="btn btn-rounded btn-primary"><i class="fas fa-plus"></i>&nbsp;
            Registrar</a>
    </div>


    <section class="card">
        <div class="card-block">
            <table id="example" class="display table table-striped" cellspacing="0" width="100%">
                <thead class="table-primary">
                    <tr>
                        <th>id</th>
                        <th>Creado por</th>
                        <th>Membresia</th>
                        <th>Dni</th>
                        <th>Nombres</th>
                        <th>Usuario</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th>Desde</th>
                        <th>Hasta</th>
                        <th>Dias Rest.</th>
                        <th>Pago</th>
                        <th>Foto</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($sql as $key => $item)
                        <tr>
                            <td>{{ $item->id_cliente }}</td>
                            <td>{{ $item->creado_por }}</td>
                            <td>{{ $item->nomMem }}</td>
                            <td>{{ $item->dni }}</td>
                            <td>{{ $item->nombre }}</td>
                            <td>{{ $item->usuario }}</td>
                            <td>{{ $item->correo }}</td>
                            <td>{{ $item->telefono }}</td>
                            <td>{{ $item->direccion }}</td>
                            <td>{{ $item->desde }}</td>
                            <td>{{ $item->hasta }}</td>
                            <td>

                                @if ($item->DR <= 7 and $item->DR >= 5)
                                    <span class="badge bg-warning">{{ $item->DR }}</span>
                                @else
                                    @if ($item->DR < 5)
                                        <span class="badge bg-danger p-2">{{ $item->DR }}</span>
                                    @else
                                        <span class="badge bg-success p-2">{{ $item->DR }}</span>
                                    @endif
                                @endif
                            </td>
                            <td>

                                @if ($item->debe == null or $item->debe == 0)
                                    <span class="badge bg-success">Pagado</span>
                                @else
                                    <span class="badge bg-danger">Deuda</span>
                                @endif
                            </td>

                            <td>
                                @if ($item->foto == null)
                                    <a class="text-danger" data-toggle="modal"
                                        data-target=".bd-example-modal-md-{{ $item->id_cliente }}"
                                        href="">Agregar</a>
                                @else
                                    <a data-toggle="modal" data-target=".bd-example-modal-md-{{ $item->id_cliente }}"
                                        href="">Ver
                                        foto</a>
                                @endif
                            </td>

                            <td>
                                @if ($item->debe == null or $item->debe == 0)
                                @else
                                    <a style="top: 0"
                                        href="{{ route('cliente.pagoCliente', $item->id_cliente) }}"
                                        class="btn btn-sm btn-secondary m-1"><i class="fas fa-dollar-sign"></i> pagar</a>
                                @endif
                                <a style="top: 0" href="{{ route('cliente.show', $item->id_cliente) }}"
                                    class="btn btn-sm btn-primary m-1"><i class="fas fa-calendar-plus"></i> Renovar</a>

                                <a style="top: 0" href="{{ route('cliente.datosCliente', $item->id_cliente) }}"
                                    class="btn btn-sm btn-info m-1"><i class="fas fa-eye"></i></a>

                                <a style="top: 0" href="{{ route('cliente.edit', $item->id_cliente) }}"
                                    class="btn btn-sm btn-warning m-1"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('cliente.destroy', $item->id_cliente) }}" method="post"
                                    class="d-inline formulario-eliminar">
                                    @method('delete')
                                    @csrf
                                    <a href="#" class="btn btn-sm btn-danger eliminar"
                                        data-id="{{ $item->id_cliente }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </form>
                            </td>

                            <div class="modal fade bd-example-modal-md-{{ $item->id_cliente }}" tabindex="-1"
                                role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="modal-close" data-dismiss="modal"
                                                aria-label="Close">
                                                <i class="font-icon-close-2"></i>
                                            </button>
                                            <h4 class="modal-title" id="myModalLabel">Modificar perfil de usuario</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group mb-1 col-12">
                                                <form action="{{ route('usuario.actualizarImagen') }}"
                                                    enctype="multipart/form-data" method="POST">
                                                    @csrf
                                                    <div class="alert alert-danger">Se le recomienda subir una imagen en un
                                                        formato válido y no muy pesado.</div>
                                                    <input hidden type="hidden" name="id"
                                                        value="{{ $item->id_cliente }}">
                                                    <div class="d-flex justify-content-center">
                                                        @if ($item->foto != null)
                                                            <img class="rounded-circle" style="width: 300px;height: 300px;"
                                                                src="{{ asset("foto/usuario/$item->foto") }}"
                                                                alt="">
                                                        @endif
                                                    </div>
                                                    <div class="fl-flex-label mb-4 col-12">
                                                        <input type="file" name="foto"
                                                            class="input form-control-file input__text"
                                                            value="{{ old('foto') }}">
                                                        @error('foto')
                                                            <small class="error error__text">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="pb-1 pt-2 text-right mt-2">
                                                        @if ($item->foto != null)
                                                            <a href="{{ route('usuario.eliminarImagen', $item->id_cliente) }}"
                                                                class="btn btn-rounded btn-danger">Eliminar</a>
                                                            <button type="submit"
                                                                class="btn btn-rounded btn-primary">Modificar</button>
                                                        @else
                                                            <button type="submit"
                                                                class="btn btn-rounded btn-primary">Agregar</button>
                                                        @endif

                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!--.modal-->

                            

                            


                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

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
