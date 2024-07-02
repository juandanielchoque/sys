@extends('layouts/app')
@section('titulo', 'membresia')

@section('content')

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



    <h4 class="text-center text-secondary">ASISTENCIAS DE CLIENTES</h4>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100" id="exampleModalLabel">Reporte de asistencias</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('reporte.asistencia.pdf') }}" method="get" target="_blank">
                    <div class="modal-body">
                        <select required name="cliente" class="form-control">
                            <option value="">--seleccionar...--</option>
                            @foreach ($cliente as $item)
                                <option value="{{ $item->id_cliente }}">{{ $item->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Generar reporte</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <section class="card">
        <div class="card-block table-responsive">
            <div>
                <a data-toggle="modal" data-target="#exampleModal" class="btn btn-primary"><i class="fas fa-file-excel"></i>
                    Reportes</a>
                <a href="{{ route('reporte.asistencia') }}" class="btn btn-success"><i class="fas fa-file-excel"></i>
                    Descargar excel</a>
            </div>
            <table id="example2" class="display table table-striped" cellspacing="0" width="100%">
                <thead class="table-primary">
                    <tr>
                        <th>id</th>
                        <th>Cliente</th>
                        <th>Fecha y Hora</th>
                        <th>Marcado Por</th>
                        {{-- <th></th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sql as $item2)
                        <tr>
                            <td>{{ $item2->id_asistencia }}</td>
                            <td>{{ $item2->nombre }}</td>
                            <td>{{ $item2->fecha_hora }}</td>
                            <td>{{ $item2->marcado_por }}</td>
                            {{-- <td>
                                <a style="top: 0" href="{{ route('asistencia.edit', $item2->id_asistencia) }}"
                                    class="btn btn-sm btn-warning m-1"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('asistencia.destroy', $item2->id_asistencia) }}" method="post"
                                    class="d-inline formulario-eliminar">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="text-right">
                {{ $sql->links('pagination::bootstrap-4') }}
                Mostrando {{ $sql->firstItem() }} - {{ $sql->lastItem() }} de {{ $sql->total() }} resultados.
            </div>
        </div>
    </section>



@endsection
