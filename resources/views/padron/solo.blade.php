<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Consulta Padron</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <script src="
    https://cdn.jsdelivr.net/npm/sweetalert2@11.26.25/dist/sweetalert2.all.min.js
    "></script>
    <link href="
    https://cdn.jsdelivr.net/npm/sweetalert2@11.26.25/dist/sweetalert2.min.css
    " rel="stylesheet">

    <style>
        body {
            min-height: 100vh;

            background:
                linear-gradient(rgba(110, 0, 0, .88), rgba(70, 0, 0, .95)),
                url('assets/fondo.jpg');

            background-size: cover;
            background-position: center;

            font-family: 'Segoe UI', sans-serif;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 25px;
        }

        .main-wrapper {
            width: 100%;
            max-width: 980px;

            background: #f3f3f3;

            border-radius: 28px;

            padding: 28px;

            box-shadow: 0 20px 45px rgba(0, 0, 0, .35);
        }

        /*
        |--------------------------------------------------------------------------
        | BANNER
        |--------------------------------------------------------------------------
        */

        .banner-wrapper{
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 25px;
        }

        .titulo-banner{

            background: white;

            border-radius: 14px;

            color: #a40000;

            font-size: 28px;
            font-weight: 900;

            text-transform: uppercase;

            letter-spacing: 1px;

            text-align: center;

            padding: 8px 20px;

            margin-bottom: 5px;

            border: 2px solid #d10000;

            box-shadow: 0 5px 15px rgba(0,0,0,.12);
        }

        .banner-card {
            background: white;

            border-radius: 20px;

            overflow: hidden;

            border: 3px solid #d10000;

            box-shadow: 0 10px 25px rgba(0, 0, 0, .18);
        }

        .banner-img {
            width: 100%;
            height: 110px;

            object-fit: cover;

            display: block;
        }

        .candidatos-wrapper {
            display: grid;
            grid-template-columns: 1fr ;
            gap: 14px;
            margin-top: 8px;
        }

        .candidato-card {
            background: #fff4f4;
            border: 1px solid #ef9a9a;
            border-radius: 14px;
            padding: 18px;
            display: flex;
            align-items: center;
            gap: 16px;
            min-height: 150px;
        }

        .candidato-img {
            width: 92px;
            height: 92px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #e53935;
            background: white;
        }

        .candidato-lista {
            color: #d00000;
            font-size: 14px;
            font-weight: 800;
        }

        .candidato-nombre {
            color: #111;
            font-size: 28px;
            font-weight: 900;
            line-height: 1.1;
        }

        .candidato-cargo {
            color: #d00000;
            font-size: 15px;
            font-weight: 800;
            text-transform: uppercase;
        }

        .candidato-opcion {
            color: #111;
            font-size: 22px;
            font-weight: 800;
        }

        @media(max-width:768px) {
            .candidatos-wrapper {
                grid-template-columns: 1fr;
            }

            .candidato-nombre {
                font-size: 20px;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | BUSCADOR
        |--------------------------------------------------------------------------
        */

        .consulta-card {
            margin-top: 20px;

            background: #ececec;

            border-radius: 22px;

            padding: 22px;

            border: 1px solid #d5d5d5;
        }

        .form-label {
            font-weight: 800;
            color: #b00000;
            margin-bottom: 10px;
        }

        .form-control {
            border-radius: 18px;

            border: 1px solid #d5d5d5;

            padding: 16px 18px;

            font-size: 20px;

            height: 56px;
        }

        .btn-consultar {
            height: 56px;

            border-radius: 18px;

            border: none;

            font-size: 22px;
            font-weight: 800;

            background: linear-gradient(135deg, #d40000, #9f0000);

            color: white;

            transition: .2s;
        }

        .btn-consultar:hover {
            transform: scale(1.01);

            background: linear-gradient(135deg, #bc0000, #7e0000);

            color: white;
        }

        /*
        |--------------------------------------------------------------------------
        | RESULTADO
        |--------------------------------------------------------------------------
        */

        .resultado-card {
            margin-top: 30px;

            border-radius: 24px;

            overflow: hidden;

            background: white;

            box-shadow: 0 15px 35px rgba(0, 0, 0, .12);
        }

        .resultado-header {
            background: linear-gradient(135deg, #cf0000, #8b0000);

            color: white;

            padding: 20px 22px;

            font-size: 18px;
            font-weight: 900;

            text-transform: uppercase;
        }

        .dato-label {
            font-size: 13px;

            font-weight: 800;

            text-transform: uppercase;

            color: #777;

            margin-bottom: 8px;
        }

        .dato-value {
            background: #f2f2f2;

            border-radius: 18px;

            padding: 16px 18px;

            font-size: 15px;
            font-weight: 800;

            color: #111;

            border-left: 5px solid #c00000;
        }

        /*
        |--------------------------------------------------------------------------
        | VACIO
        |--------------------------------------------------------------------------
        */

        .resultado-vacio {
            margin-top: 28px;

            background: #fff5f5;

            border: 2px dashed #d60000;

            border-radius: 22px;

            padding: 35px 20px;

            text-align: center;
        }

        .resultado-vacio i {
            font-size: 60px;

            color: #d60000;

            margin-bottom: 15px;
        }

        .resultado-vacio h4 {
            font-weight: 900;

            color: #b00000;
        }

        .resultado-vacio p {
            color: #666;

            margin-bottom: 0;
        }

        /*
        |--------------------------------------------------------------------------
        | RESPONSIVE
        |--------------------------------------------------------------------------
        */

        @media(max-width:768px) {
            .candidatos-wrapper {
                grid-template-columns: 1fr 1fr;
            }
        }

        .btn-whatsapp {
            background: #198754;
            color: white;
            border-radius: 18px;
            font-size: 20px;
            font-weight: 800;
            padding: 14px;
            box-shadow: 0 8px 18px rgba(0,0,0,.18);
        }

        .btn-whatsapp:hover {
            background: #157347;
            color: white;
        }

        .botones-acciones{
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .botones-acciones .btn{
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            height: 58px;
            font-size: 18px;
            font-weight: 800;
            border-radius: 18px;
        }

        .btn-padron{
            background: #0d6efd;
            color: white;
        }

        .btn-padron:hover{
            background: #0b5ed7;
            color: white;
        }

        .btn-simulador{
            background: #d61414;
            color: white;
            margin-right: 3px;
        }

        .btn-simulador:hover{
            background: #000;
            color: white;
        }

        @media (max-width: 576px){

            .botones-acciones{
                gap: 6px;
            }

            .botones-acciones .btn{
                height: 46px;
                font-size: 12px;
                padding: 6px;
                border-radius: 12px;
            }

            .botones-acciones .btn i{
                font-size: 14px;
            }
        }

        @media (max-width: 576px) {

            body {
                padding: 8px;
                align-items: flex-start;
            }

            .main-wrapper {
                padding: 12px;
                border-radius: 18px;
            }

            .candidatos-wrapper {
                grid-template-columns: 1fr;
                gap: 8px;
            }

            .candidato-card {
                padding: 8px;
                gap: 8px;
                min-height: auto;
                border-radius: 12px;
                flex-direction: column;
                text-align: center;
            }

            .candidato-img {
                width: 58px;
                height: 58px;
                border-width: 3px;
            }

            .candidato-nombre {
                font-size: 14px;
                line-height: 1.05;
            }

            .candidato-cargo {
                font-size: 10px;
            }

            .candidato-opcion {
                font-size: 11px;
            }

            .consulta-card {
                margin-top: 10px;
                padding: 12px;
                border-radius: 16px;
            }

            .form-label {
                font-size: 13px;
                margin-bottom: 5px;
            }

            .form-control {
                height: 44px;
                font-size: 16px;
                padding: 8px 12px;
                border-radius: 12px;
            }

            .btn-consultar {
                height: 44px;
                font-size: 16px;
                border-radius: 12px;
            }

            .resultado-card {
                margin-top: 14px;
                border-radius: 16px;
            }

            .resultado-header {
                padding: 10px 14px;
                font-size: 14px;
            }

            .card-body {
                padding: 12px !important;
            }

            .row.g-4 {
                --bs-gutter-y: .6rem;
            }

            .dato-label {
                font-size: 10px;
                margin-bottom: 3px;
            }

            .dato-value {
                font-size: 12px;
                padding: 8px 10px;
                border-radius: 12px;
            }

            .btn-whatsapp{
                font-size: 16px;
                padding: 12px;
                border-radius: 14px;
                margin-bottom: 10px;
                margin-left: 5px;
                margin-right: 5px;
            }

            .resultado-vacio {
                margin-top: 14px;
                padding: 18px 12px;
            }

            .resultado-vacio i {
                font-size: 38px;
            }

            .resultado-vacio h4 {
                font-size: 17px;
            }

            .resultado-vacio p {
                font-size: 13px;
            }
        }
    </style>
</head>

<body>

    <div class="main-wrapper">

        <!-- BANNER -->
        <div class="candidatos-wrapper">

            <div class="candidato-card">
                <img src="{{ Storage::url($inte->imagen) }}" class="candidato-img">

                <div>
                    <div class="candidato-nombre">Manuel Aguilar</div>
                    <div class="candidato-cargo">Intendente</div>
                    <div class="candidato-opcion">Lista 2A</div>
                </div>
            </div>

            {{-- <div class="candidato-card">
                <img src="{{ Storage::url($con->imagen) }}" class="candidato-img">

                <div>
                    <div class="candidato-nombre">{{$con->nombre}}</div>
                    <div class="candidato-cargo">Concejal Municipal</div>
                    <div class="candidato-opcion">{{$con->lista->descripcion}} - Opcion {{$con->orden}}</div>
                </div>
            </div> --}}

        </div>

        <!-- BUSCADOR -->
        <div class="consulta-card">

            <form method="GET">

                <div class="row g-3 align-items-end">

                    <div class="col-md-8">

                        <label class="form-label">
                            Número de documento
                        </label>

                        <input
                            type="text"
                            name="documento"
                            class="form-control"
                            placeholder="Ej.: 1234567"
                            value="{{ request()->documento }}">

                    </div>

                    <div class="col-md-4 d-grid">

                        <button type="submit" class="btn btn-consultar">

                            <i class="bi bi-search"></i>
                            Consultar

                        </button>

                    </div>

                </div>

            </form>

        </div>

        @if (empty($data))



            <!-- VACIO -->
            <div class="resultado-vacio">

                <i class="bi bi-person-x-fill"></i>

                <h4>
                    No se encuentra votante
                </h4>

                <p>
                    Ingrese un número de documento válido para realizar la consulta.
                </p>

            </div>


            {{-- <div class="botones-acciones">

                <a href="{{ route('simulacion', ['padron_id' => 0,'back' => Route::currentRouteName()]) }}" class="btn btn-simulador">

                    <i class="bi bi-play-circle"></i>
                    Iniciar simulador sin consultar datos

                </a>

            </div> --}}

        @else

            <!-- RESULTADO -->
            <div class="resultado-card">

                <div class="card-body p-4">

                    <div class="row g-4">

                        <!-- DOCUMENTO -->
                        <div class="col-md-6">

                            <div class="dato-label">
                                Documento
                            </div>

                            <div class="dato-value">
                                {{ number_format($data->documento, 0, ',', '.') }} - {{ $data->nombre }} {{ $data->apellido }}
                            </div>

                        </div>

                        <!-- LOCAL -->
                        <div class="col-md-6">

                            <div class="dato-label">
                                Local de Votación
                            </div>

                            <div class="dato-value">
                                {{ $data->local->descripcion }}
                            </div>

                        </div>

                        <!-- MESA -->
                        <div class="col-6 col-md-3">

                            <div class="dato-label">
                                Mesa
                            </div>

                            <div class="dato-value text-danger">
                                {{ $data->mesa }}
                            </div>

                        </div>

                        <!-- ORDEN -->
                        <div class="col-6 col-md-3">

                            <div class="dato-label">
                                Orden
                            </div>

                            <div class="dato-value text-danger">
                                {{ $data->orden }}
                            </div>

                        </div>

                        <div class="col-6 col-md-6" style="display: none">

                            <div class="dato-label">
                                Estado
                            </div>

                            <div class="dato-value text-danger">
                                <input type="text" name="estado_id" id="estado_id" value="{{ $estado_id }}">
                                <input type="text" name="mensaje" id="mensaje" value="{{ $mensaje }}">
                            </div>

                        </div>

                    </div>

                </div>

                @if (!empty($data))

                    @php

                        $mensaje = "Lista 2A Manuel Aguilar.\n"
                            . "Datos de votación:\n"
                            . "Documento: {$data->documento}\n"
                            . "Nombre: {$data->nombre} {$data->apellido}\n"
                            . "Local: {$data->local->descripcion}\n"
                            . "Mesa: {$data->mesa}\n"
                            . "Orden: {$data->orden}";

                        $whatsapp = "https://wa.me/?text=" . urlencode($mensaje);

                    @endphp

                    <div class="botones-acciones">

                        <a href="{{ $whatsapp }}"
                            target="_blank"
                            class="btn btn-whatsapp">

                            <i class="bi bi-whatsapp"></i>
                            Compartir datos

                        </a>

                        {{-- <a href="{{ route('simulacion', ['padron_id' => $data->id,'back' => Route::currentRouteName()]) }}" class="btn btn-simulador">

                            <i class="bi bi-play-circle"></i>
                            Iniciar simulador

                        </a> --}}

                    </div>

                @endif

            </div>

        @endif

    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {

        let estadoId = parseInt(document.getElementById('estado_id').value || 0);
        let mensaje = document.getElementById('mensaje').value;

        if (estadoId >= 2) {
            Swal.fire({
                title: 'Atención',
                text: mensaje,
                icon: 'warning',
                draggable: true
            });
        }

    });
    </script>
</body>

</html>
