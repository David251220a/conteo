@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/elements/alert.css')}}">
    <link href="{{asset('assets/css/elements/infobox.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    <div class="col-lg-12 layout-spacing">

        <h2 class="mt-3">Crear Usuario</h2>
        @include('varios.mensaje')
        <div class="widget-content widget-content-area">
            <form action="{{route('user.store')}}" method="post" onsubmit="
                    if (this.dataset.enviando === '1') return false;
                    this.dataset.enviando = '1';
                    document.getElementById('btnEnviar').disabled = true;
                    document.getElementById('btnEnviar').innerText = 'Enviando...';"
            >
                @csrf
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form-row mb-2">
                            <div class="form-group col-md-3">
                                <label for="">Username</label>
                                <input type="text" class="form-control" name="username" id="username" value="{{old('username')}}" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Nombre</label>
                                <input type="text" class="form-control" name="name" value="{{old('name')}}" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">Email</label>
                                <input type="text" class="form-control" name="email" value="{{old('email')}}" >
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">Contraseña</label>
                                <input type="password" class="form-control" name="password" id="password" value="{{old('password')}}" >
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">Repetir Contraseña</label>
                                <input type="password" class="form-control" name="password_rep" id="password_rep" value="{{old('password')}}"
                                onkeyup="verificar_pass()" >
                                <span id="msj" style="display: none"><p style="color: red">Las contraseñas no coinciden!!</p></span>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">Grupo</label>
                                <select name="rol" id="rol" class="form-control">
                                    <option value=""></option>
                                    @foreach ($role as $item)
                                        <option value="{{ $item->name }}" {{ old('rol') ? 'selected' : null }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <button id="btnEnviar" type="submit" class="btn btn-success">
                        Grabar
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('form');

            form.addEventListener('keydown', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault(); // 🔥 evita el submit
                    return false;
                }
            });
        });
    </script>
@endsection
