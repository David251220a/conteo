<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Simulación de Votación</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f8dada;
            font-family: Arial, Helvetica, sans-serif;
        }

        .titulo-voto {
            background: #e73535;
            color: white;
            text-align: center;
            font-size: 34px;
            font-weight: 900;
            padding: 6px 10px;
            text-shadow: 2px 2px 4px #555;
            margin-bottom: 10px;
        }

        .card-voto {
            background: white;
            border: 2px solid #d8d8d8;
            min-height: 270px;
            padding: 25px 20px;
            cursor: pointer;
            transition: all .2s ease;
            height: 100%;
        }

        .card-voto:hover {
            border: 6px solid #e92d2d;
            box-shadow: 0 0 15px rgba(233, 45, 45, .7);
            transform: scale(1.01);
        }

        .movimiento-voto {
            font-size: 28px;
            font-weight: 900;
            text-transform: uppercase;
            text-align: center;
            margin-bottom: 25px;
        }

        .foto-voto {
            width: 160px;
            height: 150px;
            object-fit: contain;
        }

        .lista-texto {
            font-size: 28px;
            font-weight: 900;
            line-height: 1;
        }

        .lista-numero {
            font-size: 62px;
            font-weight: 900;
            line-height: 1;
        }

        .lista-sigla {
            font-size: 28px;
            line-height: 1;
        }

        .nombre-voto {
            font-size: 28px;
            text-align: center;
            margin-top: 25px;
        }

        .voto-blanco {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            height: 100%;
            min-height: 270px;
            text-align: center;
        }

        .card-concejal {
            min-height: 180px !important;
            padding: 10px !important;
        }

        .card-concejal .movimiento-voto {
            font-size: 18px;
            margin-bottom: 8px;
        }

        .card-concejal .foto-voto {
            width: 90px;
            height: 90px;
        }

        .card-concejal .lista-numero {
            font-size: 28px;
        }

        .card-concejal .nombre-voto {
            font-size: 20px;
            margin-top: 8px;
            line-height: 1.1;
            font-weight: 600;
        }

        .card-seleccionado {
            background: #fff;
            border: 5px solid #e92d2d;
            height: 560px;
            text-align: center;
            position: relative;
        }

        .cargo-seleccionado {
            font-size: 26px;
            font-weight: 900;
            padding: 14px;
            border-bottom: 1px solid #777;
        }

        .contenido-seleccionado {
            height: calc(100% - 75px);
            padding: 25px 15px 80px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-around;
        }

        .contenido-seleccionado h2 {
            font-size: 30px;
            font-weight: 900;
            margin: 0;
        }

        .contenido-seleccionado h3 {
            font-size: 30px;
            font-weight: 900;
            margin: 0;
        }

        .foto-seleccionado {
            width: 210px;
            height: 190px;
            object-fit: contain;
        }

        .contenido-seleccionado h4 {
            font-size: 28px;
            font-weight: 900;
            margin: 0;
        }

        .contenido-seleccionado p {
            font-size: 24px;
            margin: 0;
        }

        .btn-modificar {
            position: absolute;
            bottom: 18px;
            left: 50%;
            transform: translateX(-50%);
            font-weight: 800;
            padding: 10px 35px;
        }

        .acciones-seleccion {
            height: 560px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .btn-accion {
            width: 100%;
            height: 50%;
            border: none;
            color: #fff;
            font-weight: 900;
            font-size: 45px;
        }

        .btn-accion span {
            display: block;
            font-size: 24px;
            line-height: 1;
        }

        .btn-reiniciar {
            background: #ff7a00;
        }

        .btn-imprimir {
            background: #00a000;
        }

        @media (max-width: 991px) {
            .card-seleccionado {
                height: 500px;
            }

            .acciones-seleccion {
                height: 180px;
                flex-direction: row;
            }

            .btn-accion {
                height: 100%;
            }
        }

        @media (max-width: 575px) {
            .card-seleccionado {
                height: 420px;
            }

            .cargo-seleccionado {
                font-size: 20px;
            }

            .contenido-seleccionado h2,
            .contenido-seleccionado h3 {
                font-size: 22px;
            }

            .foto-seleccionado {
                width: 140px;
                height: 130px;
            }

            .contenido-seleccionado h4 {
                font-size: 21px;
            }

            .btn-accion span {
                font-size: 18px;
            }
        }

        @media (max-width: 576px) {

            .card-concejal {
                min-height: 150px !important;
                padding: 6px !important;
            }

            .card-concejal .foto-voto {
                width: 65px;
                height: 65px;
            }

            .card-concejal .movimiento-voto {
                font-size: 14px;
            }

            .card-concejal .lista-numero {
                font-size: 20px;
            }

            .card-concejal .nombre-voto {
                font-size: 11px;
            }
        }

        @media (max-width: 991px) {

            .titulo-voto {
                font-size: 26px;
            }

            .movimiento-voto {
                font-size: 23px;
            }

            .nombre-voto {
                font-size: 23px;
            }
        }

        @media (max-width: 575px) {

            .container-fluid {
                padding-left: 8px;
                padding-right: 8px;
            }

            .titulo-voto {
                font-size: 20px;
            }

            .card-voto {
                min-height: auto;
                padding: 18px 12px;
            }

            .movimiento-voto {
                font-size: 19px;
                margin-bottom: 15px;
            }

            .foto-voto {
                width: 115px;
                height: 110px;
            }

            .lista-texto {
                font-size: 20px;
            }

            .lista-numero {
                font-size: 44px;
            }

            .lista-sigla {
                font-size: 20px;
            }

            .nombre-voto {
                font-size: 21px;
                margin-top: 15px;
            }

            .voto-blanco {
                min-height: 150px;
                font-size: 25px;
            }
        }

        .final-wrapper {
            min-height: 100vh;
            background: #f8dada;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .final-card {
            width: 520px;
            max-width: 100%;
            background: #fff;
            border-radius: 14px;
            border-top: 5px solid #e73535;
            padding: 14px;
            box-shadow: 0 10px 30px rgba(0,0,0,.12);
        }

        .final-frase {
            color: #e73535;
            font-size: 22px;
            font-weight: 900;
            font-style: italic;
            text-align: center;
            line-height: 1.35;
            padding: 5px 20px;
        }

        .apoyado-box {
            border: 1px solid #ff8d8d;
            background: #fde8e8;
            border-radius: 8px;
            padding: 7px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .apoyado-img {
            width: 58px;
            height: 58px;
            object-fit: contain;
            border: 2px solid #e73535;
            border-radius: 8px;
            background: #fff;
        }

        .apoyado-label {
            font-size: 10px;
            color: #e73535;
            font-weight: 900;
            letter-spacing: 1px;
        }

        .apoyado-nombre {
            font-size: 14px;
            font-weight: 900;
        }

        .vota-titulo {
            background: #e73535;
            color: #fff;
            text-align: center;
            font-weight: 900;
            padding: 5px;
            margin-top: 8px;
            border-radius: 7px 7px 0 0;
        }

        .resumen-voto {
            border: 1px solid #ff8d8d;
            border-radius: 0 0 8px 8px;
            padding: 5px;
        }

        .resumen-item {
            border: 1px solid #ff8d8d;
            border-radius: 6px;
            padding: 4px;
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 4px;
        }

        .badge-lista {
            background: #e73535;
            color: #fff;
            font-size: 11px;
            font-weight: 900;
            border-radius: 6px;
            padding: 4px 9px;
            white-space: nowrap;
        }

        .resumen-img {
            width: 34px;
            height: 34px;
            object-fit: contain;
            border: 1px solid #ff8d8d;
            border-radius: 5px;
        }

        .resumen-item strong {
            display: block;
            font-size: 13px;
            line-height: 1;
        }

        .resumen-item small {
            display: block;
            color: #e73535;
            font-size: 10px;
            font-weight: 900;
            line-height: 1;
        }

        .btn-final {
            width: 100%;
            border-radius: 9px;
            padding: 12px;
            font-weight: 900;
            font-size: 16px;
        }

        .btn-compartir {
            background: #e73535;
            color: #fff;
            border: 2px solid #e73535;
        }

        .btn-imagen {
            background: #fff;
            color: #e73535;
            border: 2px solid #e73535;
        }

        .final-footer {
            text-align: center;
            font-size: 11px;
            color: #777;
            margin-top: 8px;
        }

        @media (max-width: 575px) {
            .final-frase {
                font-size: 18px;
                padding: 4px;
            }

            .final-card {
                padding: 10px;
            }

            .btn-final {
                font-size: 14px;
            }
    }
    </style>

    @livewireStyles

</head>

<body>

    @livewire('simulacion.simulacion-general')

    @livewireScripts

</body>

</html>
