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



    <h4 class="text-center text-secondary">LISTA DE MEMBRESIAS</h4>
    <div class="pb-1 pt-2">
        <a href="{{ route('membresia.create') }}" class="btn btn-rounded btn-primary"><i class="fas fa-plus"></i>&nbsp;
            Registrar</a>
    </div>


    <section class="card">
        <div class="card-block table-responsive">
            <table id="example" class="display table table-striped" cellspacing="0" width="100%">
                <thead class="table-primary">
                    <tr>
                        <th>id</th>
                        <th>Categoria</th>
                        <th>Nombre</th>
                        <th>Meses</th>
                        <th>Modo</th>
                        <th>Precio</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datos as $item2)
                        <tr>
                            <td>{{ $item2->id_membresia }}</td>
                            <td>{{ $item2->categoria }}</td>
                            <td>{{ $item2->nombre }}</td>
                            <td>{{ $item2->meses }}</td>
                            <td>{{ $item2->modo }}</td>
                            <td>{{ $item2->precio }}</td>
                            <td>
                                <a style="top: 0" href="{{ route('membresia.edit', $item2->id_membresia) }}"
                                    class="btn btn-sm btn-warning m-1"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('membresia.destroy', $item2->id_membresia) }}" method="post"
                                    class="d-inline formulario-eliminar">
                                    @method('delete')
                                    @csrf
                                    <a href="#" class="btn btn-sm btn-danger eliminar"
                                        data-id="{{ $item2->id_membresia }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

@endsection
