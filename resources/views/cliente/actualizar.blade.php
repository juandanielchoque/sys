@extends('layouts/app')
@section('titulo', "registrar usuario")

@section('content')


{{-- notificaciones --}}

@if (session('DUPLICADO'))
<script>
    $(function notificacion(){
    new PNotify({
        title:"DUPLICADO",
        type:"warning",
        text:"{{session('DUPLICADO')}}",
        styling:"bootstrap3"
    });		
});
</script>
@endif

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


<h4 class="text-center text-secondary">ACTUALIZAR USUARIO</h4>

<div class="mb-0 col-12 bg-white p-5">
    @foreach ($sql as $item)
    <form action="{{route('usuario.update',$item->id_usuario)}}" method="POST">
        @csrf
        <div class="row">
            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <input hidden type="password" name="id" value="{{$item->id_usuario}}">
                <select class="input input__select" name="tipo">
                    <option value="">Seleccionar tipo de usuario...</option>
                    @foreach ($tipoUsuario as $item2)
                    <option {{$item->tipo_usuario == $item2->id_tipo ? 'selected' : ''}} value="{{$item2->id_tipo}}">
                        {{$item2->tipo}}</option>
                    @endforeach
                </select>
                @error('tipo')
                <small class="error error__text">{{$message}}</small>
                @enderror
            </div>
            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <input type="number" name="dni" class="input input__text" id="dni" placeholder="Dni"
                    value="{{$item->dni}}">
            </div>
            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <input type="text" name="nombre" class="input input__text" id="nombre" placeholder="Nombre"
                    value="{{$item->nombre}}">
            </div>
            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <input type="text" name="apellido" class="input input__text" id="apellido" placeholder="Apellido"
                    value="{{$item->apellido}}">
            </div>
            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <input type="text" name="usuario" class="input input__text" placeholder="Usuario *"
                    value="{{old('usuario',$item->usuario)}}">
                @error('usuario')
                <small class="error error__text">{{$message}}</small>
                @enderror
            </div>

            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <input type="text" name="telefono" class="input input__text" placeholder="Telefono"
                    value="{{$item->telefono}}">
            </div>
            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <input type="text" name="direccion" class="input input__text" placeholder="Dirección"
                    value="{{$item->direccion}}">
            </div>
            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <input type="email" name="correo" class="input input__text" placeholder="Correo *"
                    value="{{old('correo',$item->correo)}}">
                @error('correo')
                <small class="error error__text">{{$message}}</small>
                @enderror
            </div>

            <div class="text-right mt-0">
                <a href="{{route('usuario.index')}}" class="btn btn-rounded btn-secondary m-2">Atras</a>
                <button type="submit" class="btn btn-rounded btn-primary">Guardar</button>
            </div>
        </div>
        
    </form>
    @endforeach
</div>




@endsection