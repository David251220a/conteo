@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/elements/alert.css') }}">

    <style>
        .resumen-votos {
            background: #b91c1c;
            color: #fff;
            border-radius: 8px;
            padding: 18px 25px;
            margin-bottom: 25px;
        }

        .resumen-votos .total {
            font-size: 32px;
            font-weight: 700;
            line-height: 1;
        }

        .resumen-votos .descripcion {
            font-size: 13px;
            opacity: .85;
            text-transform: uppercase;
            letter-spacing: .7px;
        }

        .lista-votos {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
        }

        .fila-local {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 17px 22px;
            border-bottom: 1px solid #eeeeee;
            background: #fff;
            transition: background .15s ease;
        }

        .fila-local:last-child {
            border-bottom: none;
        }

        .fila-local:hover {
            background: #fff5f5;
        }

        .local-info {
            display: flex;
            align-items: center;
            min-width: 0;
        }

        .numero-local {
            width: 36px;
            height: 36px;
            min-width: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #fef2f2;
            color: #b91c1c;
            font-weight: 700;
            margin-right: 15px;
        }

        .nombre-local {
            font-size: 15px;
            font-weight: 600;
            color: #3b3f5c;
        }

        .votos-local {
            text-align: right;
            margin-left: 15px;
        }

        .votos-local .cantidad {
            font-size: 24px;
            font-weight: 700;
            color: #b91c1c;
            line-height: 1.1;
        }

        .votos-local .texto {
            font-size: 10px;
            color: #888ea8;
            text-transform: uppercase;
            letter-spacing: .6px;
        }

        .barra-roja {
            width: 4px;
            align-self: stretch;
            background: #b91c1c;
            margin-right: 18px;
            border-radius: 4px;
        }
    </style>
@endsection


@section('content')

<div class="col-lg-12 layout-spacing">

    <div class="statbox widget box box-shadow">

        <div class="widget-content widget-content-area">

            {{-- TITULO --}}
            <div class="row align-items-center mb-4">

                <div class="col-md-12">
                    <h3 class="mb-1">Votos</h3>
                    <small class="text-muted">
                        Cantidad de votos registrados por local
                    </small>
                </div>

            </div>

            {{-- LISTADO --}}
            <div class="lista-votos mb-5">

                @forelse($data as $index => $item)

                    <div class="fila-local">

                        <div class="local-info">

                            <div class="barra-roja"></div>

                            <div class="numero-local">
                                {{ $index + 1 }}
                            </div>

                            <div>
                                <div class="nombre-local">
                                    {{ $item->local->descripcion }}
                                </div>

                                <small class="text-muted">
                                    Local de votación
                                </small>
                            </div>

                        </div>


                        <div class="votos-local">

                            <div class="cantidad">
                                {{ number_format($item->total_votos, 0, ',', '.') }}
                            </div>

                            <div class="texto">
                                votos
                            </div>

                        </div>

                    </div>

                @empty

                    <div class="p-4 text-center text-muted">
                        <i class="fas fa-info-circle mr-1"></i>
                        No existen votos registrados.
                    </div>

                @endforelse

            </div>

                        {{-- TOTAL GENERAL --}}
            <div class="resumen-votos d-flex align-items-center justify-content-between">

                <div>
                    <div class="descripcion">
                        Total de votos registrados
                    </div>

                    <div>
                        <i class="fas fa-vote-yea fa-2x"></i>
                    </div>

                </div>

                <div class="total mt-1">
                    {{ number_format($data->sum('total_votos'), 0, ',', '.') }}
                </div>


            </div>
        </div>

    </div>

</div>

@endsection


@section('js')

@endsection
