@extends('layouts/app')
@section('titulo', 'registrar membresias')

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


    <h4 class="text-center text-secondary">REGISTRO DE MEMBRESIAS</h4>

    <div class="mb-0 col-12 bg-white p-5">
        <form action="{{ route('membresia.store') }}" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="row">

                <div class="fl-flex-label mb-4 col-12 col-lg-6">
                    <input type="text" name="categoria" class="input input__text" placeholder="Categoria *"
                        value="{{ old('categoria') }}">
                    @error('categoria')
                        <small class="error error__text">{{ $message }}</small>
                    @enderror
                </div>
                <div class="fl-flex-label mb-4 col-12 col-lg-6">
                    <input type="text" name="nombre" class="input input__text" placeholder="Nombre *"
                        value="{{ old('nombre') }}">
                    @error('nombre')
                        <small class="error error__text">{{ $message }}</small>
                    @enderror
                </div>
                <div class="fl-flex-label mb-4 col-12 col-lg-6">
                    <input type="number" name="mes" class="input input__text" id="mes" placeholder="Meses *"
                        value="{{ old('mes') }}">
                    @error('mes')
                        <small class="error error__text">{{ $message }}</small>
                    @enderror
                </div>

                <div class="fl-flex-label mb-4 col-12 col-lg-6">
                    <select name="modo" class="input input__select">
                        <option value="">Selecionar Modo</option>
                        <option value="diario">Diario</option>
                        <option value="interdiario">InterDiario</option>
                    </select>
                    @error('modo')
                        <small class="error error__text">{{ $message }}</small>
                    @enderror
                </div>

                <div class="fl-flex-label mb-4 col-12 col-lg-6">
                    <input type="text" name="precio" class="input input__text" id="precio" placeholder="Precio *"
                        value="{{ old('precio') }}">
                    @error('precio')
                        <small class="error error__text">{{ $message }}</small>
                    @enderror
                </div>


                <div class="text-right mt-0">
                    <a href="{{ route('membresia.index') }}" class="btn btn-rounded btn-secondary m-2">Atras</a>
                    <button type="submit" class="btn btn-rounded btn-primary">Guardar</button>
                </div>
            </div>

        </form>
    </div>




@endsection
