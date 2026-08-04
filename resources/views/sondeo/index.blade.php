<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sondeo de Votos</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body {
        background: #7d8181;
        font-family: Arial, Helvetica, sans-serif;
    }

    .container-fluid {
        padding-left: 8px;
        padding-right: 8px;
    }

    .titulo-voto {
        background: #181818;
        color: white;
        text-align: center;
        font-size: 30px;
        font-weight: 900;
        padding: 6px 10px;
        text-shadow: 2px 2px 4px #555;
        margin-bottom: 8px;
        text-transform: uppercase;
    }

    .card-voto {
        background: white;
        border: 2px solid #d8d8d8;
        min-height: 250px;
        padding: 20px 15px;
        cursor: pointer;
        transition: all .2s ease;
        height: 100%;
    }

    .card-voto:hover {
        /* border: 5px solid #e92d2d; */
        /* box-shadow: 0 0 12px rgba(233, 45, 45, .7); */
    }

    .movimiento-voto {
        font-size: 24px;
        font-weight: 900;
        text-transform: uppercase;
        text-align: center;
        margin-bottom: 18px;
    }

    .foto-voto {
        width: 140px;
        height: 130px;
        object-fit: contain;
    }

    .lista-texto {
        font-size: 24px;
        font-weight: 900;
        line-height: 1;
    }

    .lista-numero {
        font-size: 48px;
        font-weight: 900;
        line-height: 1;
    }

    .lista-sigla {
        font-size: 22px;
        line-height: 1;
    }

    .nombre-voto {
        font-size: 24px;
        text-align: center;
        margin-top: 18px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .voto-blanco {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        height: 100%;
        text-align: center;
    }

    .card-concejal {
        min-height: 165px !important;
        padding: 8px !important;
    }

    .card-concejal .movimiento-voto {
        font-size: 16px;
        margin-bottom: 6px;
    }

    .card-concejal .foto-voto {
        width: 75px;
        height: 75px;
    }

    .card-concejal .lista-numero {
        font-size: 24px;
    }

    .card-concejal .lista-sigla {
        font-size: 14px;
    }

    .card-concejal .nombre-voto {
        font-size: 16px;
        margin-top: 6px;
        line-height: 1.1;
    }

    .card-seleccionado {
        background: #fff;
        /* border: 4px solid #e92d2d; */
        height: 500px;
        text-align: center;
        position: relative;
    }

    .cargo-seleccionado {
        font-size: 24px;
        font-weight: 900;
        padding: 10px;
        border-bottom: 1px solid #777;
    }

    .contenido-seleccionado {
        height: calc(100% - 65px);
        padding: 18px 10px 70px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-between;
    }

    .contenido-seleccionado h2,
    .contenido-seleccionado h3 {
        font-size: 26px;
        font-weight: 900;
        margin: 0;
    }

    .foto-seleccionado {
        width: 180px;
        height: 165px;
        object-fit: contain;
    }

    .contenido-seleccionado h4 {
        font-size: 25px;
        font-weight: 900;
        margin: 0;
        text-transform: uppercase;
    }

    .contenido-seleccionado p {
        font-size: 22px;
        margin: 0;
    }

    .btn-modificar {
        position: absolute;
        bottom: 14px;
        left: 50%;
        transform: translateX(-50%);
        font-weight: 800;
        padding: 8px 28px;
    }

    .acciones-seleccion {
        height: 500px;
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
        font-size: 38px;
    }

    .btn-accion span {
        display: block;
        font-size: 22px;
        line-height: 1;
    }

    .btn-reiniciar {
        background: #ff7a00;
    }

    .btn-imprimir {
        background: #00a000;
    }

    .final-wrapper {
        min-height: calc(100vh - 60px);
        background: #f8dada;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 10px;
    }

    .final-card {
        width: 520px;
        max-width: 100%;
        background: #fff;
        border-radius: 14px;
        /* border-top: 5px solid #e73535; */
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
        width: 55px;
        height: 55px;
        object-fit: contain;
        border: 2px solid #e73535;
        border-radius: 8px;
        background: #fff;
    }

    .apoyado-label {
        font-size: 10px;
        color: #e73535;
        font-weight: 900;
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
        padding: 4px 8px;
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
        padding: 10px;
        font-weight: 900;
        font-size: 15px;
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
        .titulo-voto {
            font-size: 17px;
            padding: 5px;
            margin-bottom: 5px;
        }

        .row {
            --bs-gutter-x: .25rem;
            --bs-gutter-y: .25rem;
        }

        .card-voto {
            min-height: 160px;
            padding: 8px 5px;
        }

        .movimiento-voto {
            font-size: 13px;
            margin-bottom: 6px;
        }

        .foto-voto {
            width: 62px;
            height: 62px;
        }

        .lista-texto {
            font-size: 13px;
        }

        .lista-numero {
            font-size: 18px;
        }

        .lista-sigla {
            font-size: 12px;
        }

        .nombre-voto {
            font-size: 8px;
            margin-top: 7px;
            line-height: 1.1;
        }

        .voto-blanco {
            min-height: 160px;
        }

        .card-concejal {
            min-height: 125px !important;
            padding: 5px !important;
        }

        .card-concejal .movimiento-voto {
            font-size: 11px;
            margin-bottom: 4px;
        }

        .card-concejal .foto-voto {
            width: 48px;
            height: 48px;
        }

        .card-concejal .lista-numero {
            font-size: 7px;
        }

        .card-concejal .lista-sigla {
            font-size: 10px;
        }

        .card-concejal .nombre-voto {
            font-size: 7px;
            margin-top: 4px;
            line-height: 1.05;
        }

        .card-seleccionado {
            height: 285px;
            border-width: 3px;
        }

        .cargo-seleccionado {
            font-size: 15px;
            padding: 5px;
        }

        .contenido-seleccionado {
            height: calc(100% - 34px);
            padding: 8px 5px 42px;
        }

        .contenido-seleccionado h2,
        .contenido-seleccionado h3 {
            font-size: 15px;
        }

        .foto-seleccionado {
            width: 82px;
            height: 82px;
        }

        .contenido-seleccionado h4 {
            font-size: 14px;
            line-height: 1.05;
        }

        .contenido-seleccionado p {
            font-size: 14px;
        }

        .btn-modificar {
            bottom: 7px;
            padding: 4px 15px;
            font-size: 12px;
        }

        .acciones-seleccion {
            height: 75px;
            flex-direction: row;
            gap: 4px;
        }

        .btn-accion {
            height: 100%;
            font-size: 22px;
        }

        .btn-accion span {
            font-size: 12px;
        }

        .final-wrapper {
            min-height: calc(100vh - 45px);
            align-items: flex-start;
            padding: 6px;
        }

        .final-card {
            padding: 8px;
        }

        .final-frase {
            font-size: 15px;
            line-height: 1.2;
        }

        .apoyado-img {
            width: 45px;
            height: 45px;
        }

        .apoyado-nombre {
            font-size: 12px;
        }

        .resumen-item strong {
            font-size: 11px;
        }

        .resumen-item small {
            font-size: 8px;
        }

        .badge-lista {
            font-size: 9px;
            padding: 3px 5px;
        }

        .btn-final {
            font-size: 12px;
            padding: 8px;
        }
    }

    @media (max-width: 575px) {
        .card-seleccionado {
            height: auto;
            min-height: 285px;
            padding-bottom: 8px;
        }

        .contenido-seleccionado {
            height: auto;
            padding: 6px 4px 8px;
            gap: 6px;
        }

        .btn-modificar {
            position: static;
            transform: none;
            margin-top: 4px;
            padding: 4px 14px;
            font-size: 12px;
        }

        .contenido-seleccionado h4 {
            font-size: 12px;
            line-height: 1.05;
            word-break: break-word;
        }
    }

    .header-voto {
        background: #000;
        display: grid;
        grid-template-columns: 140px 1fr 140px;
        align-items: center;
        gap: 10px;
        padding: 5px 10px;
        margin-bottom: 8px;
        border-bottom: 3px solid #fff;
    }

    .logo-voto {
        width: 100%;
        height: 58px;
        object-fit: contain;
        display: block;

        background: rgba(255,255,255,.08);

        border: 2px solid rgba(255,255,255,.85);
        border-radius: 8px;

        padding: 3px;

        box-shadow:
            0 0 8px rgba(255,255,255,.35),
            inset 0 0 6px rgba(255,255,255,.15);
    }

    .logo-left {
        justify-self: start;
    }

    .logo-right {
        justify-self: end;
    }

    .header-voto .titulo-voto {
        background: transparent;
        color: #fff;
        margin: 0;
        padding: 0;
        font-size: 34px;
        text-shadow:
            2px 2px 0 #777,
            0 0 6px rgba(255,255,255,.4);
    }

    /* =========================
    TAMAÑOS NORMALES
    ========================= */

    .card-voto {
        min-height: 250px;
    }

    .card-concejal {
        min-height: 165px !important;
    }

    /* =========================
    CELULAR
    ========================= */

    @media (max-width: 575px) {

        .header-voto {
            grid-template-columns: 60px 1fr 60px;
            min-height: 40px;
            padding: 3px 5px;
            gap: 4px;
        }

        .logo-voto {
            height: 28px;
        }

        .header-voto .titulo-voto {
            font-size: 13px;
            line-height: 1.1;
        }

        .card-voto {
            min-height: 160px;
            padding: 5px 3px;
        }

        .movimiento-voto {
            font-size: 10px;
            margin-bottom: 4px;
        }

        .foto-voto {
            width: 45px;
            height: 45px;
        }

        .lista-numero {
            font-size: 16px;
        }

        .lista-texto,
        .lista-sigla {
            font-size: 9px;
        }

        .nombre-voto {
            font-size: 8px;
            margin-top: 4px;
        }

        .card-concejal {
            min-height: 125px !important;
            padding: 3px !important;
        }

        .card-concejal .foto-voto {
            width: 34px;
            height: 34px;
        }

        .card-concejal .movimiento-voto {
            font-size: 8px;
        }

        .card-concejal .lista-numero {
            font-size: 7px;
        }

        .card-concejal .nombre-voto {
            font-size: 6.5px;
        }
    }

    .btn-padron-final {
        background: #e73535;
        color: #fff;
        border: 2px solid #e73535;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .btn-padron-final:hover {
        background: #c91f1f;
        color: #fff;
    }

</style>

    @livewireStyles

</head>

<body>

    @livewire('sondeo.sondeo-index')

    @livewireScripts

</body>

</html>
