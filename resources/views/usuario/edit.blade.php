@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/elements/alert.css')}}">
    <link href="{{asset('assets/css/elements/infobox.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    <div class="col-lg-12 layout-spacing">

        <h2 class="mt-3">Editar Usuario: {{$user->name}}</h2>
        @include('varios.mensaje')
        <div class="widget-content widget-content-area">
            <form action="{{route('user.update', $user)}}" method="POST">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form-row mb-2">
                            <div class="form-group col-md-3">
                                <label for="">Username</label>
                                <input type="text" class="form-control" name="username" id="username" value="{{old('username', $user->username)}}" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Nombre</label>
                                <input type="text" class="form-control" name="name" value="{{old('name', $user->name)}}" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">Email</label>
                                <input type="text" class="form-control" name="email" value="{{old('email', $user->email)}}" >
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
                                        <option value="{{ $item->name }}" {{ $user->hasRole($item->id) ? 'selected' : null }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">Local</label>
                                <select name="local_id" id="local_id" class="form-control">
                                    <option value=""></option>
                                    @foreach ($locales as $item)
                                        <option value="{{ $item->id }}" {{ old('local_id', $user->local_id) == $item->id ? 'selected' : '' }}>{{ $item->descripcion }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <button type="submit" id="enviar" class="btn btn-success ml-3">Editar</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('js')
@endsection
