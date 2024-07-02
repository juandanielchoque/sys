@extends('layouts/app')
@section('titulo', "usuario")

@section('content')

{{-- notificaciones --}}


@if (session('CORRECTO'))
<script>
    $(function notificacion(){
    new PNotify({
        title:"CORRECTO",
        type:"success",
        text:"{{session('CORRECTO')}}",
        styling:"bootstrap3"
    });		
});
</script>
@endif



@if (session('INCORRECTO'))
<script>
    $(function notificacion(){
    new PNotify({
        title:"INCORRECTO",
        type:"error",
        text:"{{session('INCORRECTO')}}",
        styling:"bootstrap3"
    });		
});
</script>
@endif

<h4 class="text-center text-secondary">LISTA DE USUARIOS</h4>
<div class="pb-1 pt-2">
    <a href="{{route('usuario.create')}}" class="btn btn-rounded btn-primary"><i class="fas fa-plus"></i>&nbsp;
        Registrar</a>
</div>


<section class="card">
    <div class="card-block">
        <table id="example" class="display table table-striped" cellspacing="0" width="100%">
            <thead class="table-primary">
                <tr>
                    <th>id</th>
                    <th>Tipo</th>
                    <th>Dni</th>
                    <th>Nombres</th>
                    <th>Usuario</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th>Correo</th>
                    <th>Foto</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($sql as $item)
                <tr>
                    <td>{{$item->id_usuario}}</td>
                    <td>{{$item->tipo}}</td>
                    <td>{{$item->dni}}</td>
                    <td>{{$item->nombre}} {{$item->apellido}}</td>
                    <td>{{$item->usuario}}</td>
                    <td>{{$item->telefono}}</td>
                    <td>{{$item->direccion}}</td>
                    <td>{{$item->correo}}</td>
                    <td>
                        @if ($item->foto==null)
                        <a class="text-danger" data-toggle="modal"
                            data-target=".bd-example-modal-md-{{$item->id_usuario}}" href="">Agregar</a>
                        @else
                        <a data-toggle="modal" data-target=".bd-example-modal-md-{{$item->id_usuario}}" href="">Ver
                            foto</a>
                        @endif
                    </td>
                    <td>

                        <a style="top: 0" href="{{route('usuario.edit',$item->id_usuario)}}"
                            class="btn btn-sm btn-warning m-1"><i class="fas fa-edit"></i></a>
                        <form action="{{route('usuario.destroy',$item->id_usuario)}}" method="get"
                            class="d-inline formulario-eliminar">
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>

                    <div class="modal fade bd-example-modal-md-{{$item->id_usuario}}" tabindex="-1" role="dialog"
                        aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                                        <i class="font-icon-close-2"></i>
                                    </button>
                                    <h4 class="modal-title" id="myModalLabel">Modificar perfil de usuario</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group mb-1 col-12">
                                        <form action="{{route('usuario.actualizarImagen')}}"
                                            enctype="multipart/form-data" method="POST">
                                            @csrf
                                            <div class="alert alert-danger">Se le recomienda subir una imagen en un
                                                formato válido y no muy pesado.</div>
                                            <input hidden type="password" name="id" value="{{$item->id_usuario}}">
                                            <div class="d-flex justify-content-center">
                                                @if ($item->foto!=null)
                                                <img class="rounded-circle" style="width: 300px;height: 300px;"
                                                    src="data:image/jpg;base64,<?= base64_encode($item->foto) ?>"
                                                    alt="">
                                                @endif
                                            </div>
                                            <div class="fl-flex-label mb-4 col-12">
                                                <input type="file" name="foto"
                                                    class="input form-control-file input__text" value="{{old('foto')}}">
                                                @error('foto')
                                                <small class="error error__text">{{$message}}</small>
                                                @enderror
                                            </div>
                                            <div class="pb-1 pt-2 text-right mt-2">
                                                @if ($item->foto!=null)
                                                <a href="{{route('usuario.eliminarImagen',$item->id_usuario)}}"
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

@endsection