<div class="container-fluid py-2">

    <div class="header-voto" style="{{ $estilo_titulo }}">
        <a href="{{ route('home') }}">
            <img src="{{ Storage::url('imagenes/logo_eleccion.png') }}" class="logo-voto logo-left" alt="" style="background: white">
        </a>

        <div class="titulo-voto">
            {{ $titulo }}
        </div>
        <img src="{{ Storage::url('imagenes/header.png') }}" class="logo-voto logo-right" alt="" style="background: white">
    </div>

    @if ($paso == 1)
        <div class="row g-1">

            @foreach($intendente as $item)
                @php
                    $estilo_primero = '';
                    if($general->tipo_votacion === 2){
                        $estilo_primero = 'background-color:' . $item->movimiento->color_fondo . '; color:' . $item->movimiento->color_letra . ';';
                    }
                @endphp
                <div class="col-lg-3 col-md-3 col-3">

                    <div class="card-voto voto-blanco" wire:click="seleccionarIntendente({{ $item->id }}, {{ $modo }})" style="{{ $estilo_primero }}">

                        <div class="movimiento-voto">
                            @if ($item->orden < 90)
                                {{ $item->lista->movimiento->descripcion }}
                            @endif
                        </div>

                        <div class="d-flex align-items-center justify-content-around">
                            @if ($item->orden < 90)
                                <img src="{{ Storage::url($item->imagen) }}" class="foto-voto" alt="">
                            @endif

                            <div class="text-center">
                                <div class="lista-texto">
                                    {{ $item->orden < 90 ? '' : 'VOTO' }}
                                </div>

                                <div class="lista-numero">
                                    {{ $item->lista->descripcion }}
                                </div>

                                <div class="lista-sigla">
                                    {{ $item->lista->sigla }}
                                </div>
                            </div>
                        </div>

                        @if ($item->orden < 90)
                            <div class="nombre-voto">
                                {{ $item->nombre }} {{ $item->apellido }}
                            </div>
                        @endif

                    </div>

                </div>

            @endforeach

        </div>
    @endif


    @if ($paso == 2)
        <div class="row g-1">

            @foreach($listas as $item)

                @php
                    $estilo_segundo = '';
                    if($general->tipo_votacion === 2){
                        $estilo_segundo = 'background-color:' . $item->movimiento->color_fondo . '; color:' . $item->movimiento->color_letra . ';';
                    }
                @endphp
                <div class="col-lg-4 col-md-4 col-4">

                    <div class="card-voto voto-blanco" wire:click="seleccionarLista({{ $item->id }}, {{ $item->orden }})" style="{{ $estilo_segundo }}">

                        <div class="movimiento-voto">
                            @if ($item->orden < 90)
                                {{ $item->movimiento->descripcion }}
                            @endif
                        </div>

                        <div class="text-center">
                            <div class="lista-texto">
                                {{ $item->orden < 90 ? '' : 'VOTO' }}
                            </div>

                            <div class="lista-numero">
                                {{ $item->descripcion }}
                            </div>

                            <div class="lista-sigla">
                                {{ $item->sigla }}
                            </div>
                        </div>

                    </div>

                </div>

            @endforeach

        </div>
    @endif


    @if ($paso == 3)
        <div class="row g-1">

            @foreach($consejales as $item)

                <div class="col-lg-3 col-md-3 col-3">

                    <div class="card-voto card-concejal" wire:click="seleccionarConsejal({{ $item->id }})">

                        <div class="movimiento-voto">
                            @if ($item->orden < 90)
                                {{ $item->lista->descripcion }}
                            @endif
                        </div>

                        <div class="d-flex align-items-center justify-content-around">
                            @if ($item->orden < 90)
                                <img src="{{ Storage::url($item->imagen) }}" class="foto-voto" alt="">
                            @endif

                            <div class="text-center">
                                <div class="lista-texto">
                                    {{ $item->orden < 90 ? '' : 'VOTO' }}
                                </div>

                                <div class="lista-numero">
                                    OPCION {{ $item->orden }}
                                </div>

                                <div class="lista-sigla">
                                    {{ $item->lista->sigla }}
                                </div>
                            </div>
                        </div>

                        @if ($item->orden < 90)
                            <div class="nombre-voto">
                                {{ $item->nombre }} {{ $item->apellido }}
                            </div>
                        @endif

                    </div>

                </div>

            @endforeach

        </div>
    @endif


    @if ($paso == 4)

        <div class="row g-1 align-items-stretch">

            <div class="col-lg-5 col-md-6 col-6">
                <div class="card-seleccionado" style="{{'background-color:' . $intendenteSeleccionado->lista->movimiento->color_fondo .
                    '; color:' . $intendenteSeleccionado->lista->movimiento->color_letra . ';' }}"

                >

                    <div class="cargo-seleccionado">
                        INTENDENTE MUNICIPAL
                    </div>

                    <div class="contenido-seleccionado">
                        @if ($intendenteSeleccionado->orden < 90)
                            <h2>{{ $intendenteSeleccionado->lista->movimiento->descripcion }}</h2>
                        @endif

                        <h3>{{ ($intendenteSeleccionado->orden < 90 ? '' : 'VOTO EN ') . $intendenteSeleccionado->lista->descripcion }}</h3>

                        @if ($intendenteSeleccionado->orden < 90)
                            <img src="{{ Storage::url($intendenteSeleccionado->imagen) }}" class="foto-seleccionado" alt="">
                            <h4>{{ $intendenteSeleccionado->nombre }} {{ $intendenteSeleccionado->apellido }}</h4>
                        @endif
                    </div>

                    <button type="button" class="btn btn-secondary btn-sm btn-modificar"
                        wire:click="volverIntendente">
                        Modificar
                    </button>

                </div>
            </div>

            <div class="col-lg-5 col-md-6 col-6">
                <div class="card-seleccionado" style="{{'background-color:' . $concejalSeleccionado->lista->movimiento->color_fondo .
                    '; color:' . $concejalSeleccionado->lista->movimiento->color_letra . ';' }}"

                >

                    <div class="cargo-seleccionado">
                        CONSEJAL
                    </div>

                    <div class="contenido-seleccionado">
                        @if ($concejalSeleccionado->orden < 90)
                            <h2>{{ $concejalSeleccionado->lista->movimiento->descripcion }}</h2>
                        @endif

                        <h3>{{ ($concejalSeleccionado->orden < 90 ? '' : 'VOTO EN ') .  $concejalSeleccionado->lista->descripcion }}</h3>

                        @if ($concejalSeleccionado->orden < 90)
                            <img src="{{ Storage::url($concejalSeleccionado->imagen) }}" class="foto-seleccionado" alt="">
                            <h4>{{ $concejalSeleccionado->nombre }} {{ $concejalSeleccionado->apellido }}</h4>
                            <p style="font-weight: bold">Opción {{ $concejalSeleccionado->orden }}</p>
                        @endif
                    </div>

                    <button type="button" class="btn btn-secondary btn-sm btn-modificar"
                        wire:click="volverConcejal">
                        Modificar
                    </button>

                </div>
            </div>

            <div class="col-lg-2 col-md-12 col-12">
                <div class="acciones-seleccion">

                    <button type="button" class="btn-accion btn-reiniciar"
                        wire:click="restablecer">
                        ↻
                        <span>Reiniciar<br>Selección</span>
                    </button>

                    <button type="button" class="btn-accion btn-imprimir"
                        wire:click="imprimirSeleccion">
                        🖨
                        <span>Imprimir<br>Selección</span>
                    </button>

                </div>
            </div>

        </div>

    @endif


    @if ($paso == 5)

        <div class="final-wrapper">

            <div class="final-card">

                <div class="final-frase">
                    “ Gracias por practicar. Esperamos tu participación para fortalecer nuestra democracia. ”
                </div>

                <hr>

                <div class="vota-titulo">
                    SELECCION DE VOTO REGISTRADO
                </div>

                <div class="resumen-voto">

                    <div class="resumen-item">
                        <span class="badge-lista">{{ $intendenteSeleccionado->lista->descripcion }}</span>

                        <img src="{{ Storage::url($intendenteSeleccionado->imagen) }}" class="resumen-img" alt="">

                        <div>
                            <strong>{{ $intendenteSeleccionado->nombre }}</strong>
                            <small>INTENDENTE MUNICIPAL</small>
                        </div>

                    </div>

                    <div class="resumen-item">
                        <span class="badge-lista">{{ $concejalSeleccionado->lista->descripcion }}</span>
                        <span class="badge-lista">Opcion {{ $concejalSeleccionado->orden }}</span>

                        <img src="{{ Storage::url($concejalSeleccionado->imagen) }}" class="resumen-img" alt="">

                        <div>
                            <strong>{{ $concejalSeleccionado->nombre }}</strong>
                            <small>CONCEJAL MUNICIPAL</small>
                        </div>

                    </div>

                </div>

                <div class="row g-2 mt-2">
                    <div class="col-6">
                        <button type="button" wire:click="restablecer" class="btn-final btn-imagen">
                            Reiniciar Simulación
                        </button>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('home') }}" class="btn-final btn-padron-final">
                            <i class="bi bi-arrow-left-circle"></i>
                            Volver al Home
                        </a>
                    </div>
                </div>

                <div class="final-footer">
                    Simulador proveído por Equipo Técnico Manuel Aguilar
                </div>

            </div>

        </div>

    @endif

</div>
