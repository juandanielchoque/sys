@extends('layouts/app')
@section('titulo', "registrar usuario")

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


<h4 class="text-center text-secondary">REGISTRO DE USUARIOS</h4>

<div class="mb-0 col-12 bg-white p-5">
    <form action="{{route('usuario.store')}}" enctype="multipart/form-data" method="POST">
        @csrf
        <div class="row">
            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <select class="input input__select" name="tipo">
                    <option value="">Seleccionar tipo de usuario...</option>
                    @foreach ($sql as $item)
                    <option {{old('tipo') == $item->id_tipo ? 'selected' : ''}} value="{{$item->id_tipo}}">
                        {{$item->tipo}}</option>
                    @endforeach
                </select>
                @error('tipo')
                <small class="error error__text">{{$message}}</small>
                @enderror
            </div>
            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <input type="number" name="dni" class="input input__text" id="dni" placeholder="Dni"
                    value="{{old('dni')}}">
            </div>
            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <input type="text" name="nombre" class="input input__text" id="nombre" placeholder="Nombre"
                    value="{{old('nombre')}}">
            </div>
            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <input type="text" name="apellido" class="input input__text" id="apellido" placeholder="Apellido"
                    value="{{old('apellido')}}">
            </div>
            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <input type="text" name="usuario" class="input input__text" placeholder="Usuario *"
                    value="{{old('usuario')}}">
                @error('usuario')
                <small class="error error__text">{{$message}}</small>
                @enderror
            </div>
            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <input type="password" name="password" class="input input__text" placeholder="Contraseña *"
                    value="{{old('password')}}">
                @error('password')
                <small class="error error__text">{{$message}}</small>
                @enderror
            </div>
            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <input type="text" name="telefono" class="input input__text" placeholder="Telefono"
                    value="{{old('telefono')}}">
            </div>
            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <input type="text" name="direccion" class="input input__text" placeholder="Dirección"
                    value="{{old('direccion')}}">
            </div>
            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <input type="email" name="correo" class="input input__text" placeholder="Correo *"
                    value="{{old('correo')}}">
                @error('correo')
                <small class="error error__text">{{$message}}</small>
                @enderror
            </div>
            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <input type="file" name="foto" class="input form-control-file input__text" value="{{old('foto')}}">
            </div>
            <div class="text-right mt-0">
                <a href="{{route('usuario.index')}}" class="btn btn-rounded btn-secondary m-2">Atras</a>
                <button type="submit" class="btn btn-rounded btn-primary">Guardar</button>
            </div>
        </div>

    </form>
</div>




@endsection