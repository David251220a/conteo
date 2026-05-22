<div class="container-fluid py-2">

    <div class="titulo-voto">
        {{ $titulo }}
    </div>

    @if ($paso == 1)
        <div class="row g-2">

            @foreach($intendente as $item)

                <div class="col-lg-4 col-md-6 col-12">

                    <div class="card-voto voto-blanco" wire:click="seleccionarIntendente({{ $item->id }}, {{ $modo }})">

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
        <div class="row g-2">

            @foreach($listas as $item)

                <div class="col-lg-4 col-md-6 col-12">

                    <div class="card-voto voto-blanco" wire:click="seleccionarLista({{ $item->id }}, {{ $item->orden }})">

                        <div class="movimiento-voto">
                            @if ($item->orden < 90)
                                {{ $item->movimiento->descripcion }}
                            @endif
                        </div>

                        <div class="d-flex align-items-center justify-content-around">
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

                </div>

            @endforeach

        </div>
    @endif

    @if ($paso == 3)
        <div class="row g-2">

            @foreach($consejales as $item)

                <div class="col-lg-3 col-md-4 col-6">

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

        <div class="row g-2">

            <div class="col-lg-5 col-md-6 col-12">
                <div class="card-seleccionado">

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
                        @endif
                        @if ($intendenteSeleccionado->orden < 90)
                            <h4>{{ $intendenteSeleccionado->nombre }}</h4>
                        @endif
                    </div>

                    <button type="button" class="btn btn-secondary btn-lg btn-modificar"
                        wire:click="volverIntendente">
                        Modificar
                    </button>

                </div>
            </div>

            <div class="col-lg-5 col-md-6 col-12">
                <div class="card-seleccionado">

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
                            <h4>{{ $concejalSeleccionado->nombre }}</h4>
                            <p>Opción {{ $concejalSeleccionado->orden }}</p>
                        @endif
                    </div>

                    <button type="button" class="btn btn-secondary btn-lg btn-modificar"
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

                <div class="apoyado-box">
                    <img src="{{ Storage::url($dato->imagen) }}" class="apoyado-img" alt="">

                    <div>
                        <div class="apoyado-label">APOYADO POR</div>
                        <div class="apoyado-nombre">
                            {{ $dato->nombre }} Intendente
                        </div>
                    </div>
                </div>

                <div class="vota-titulo">
                    VOTÁ ASÍ EL 7 DE JUNIO
                </div>

                <div class="resumen-voto">

                    <div class="resumen-item">
                        <span class="badge-lista">{{ $dato->lista->descripcion }}</span>

                        <img src="{{ Storage::url($dato->imagen) }}" class="resumen-img" alt="">

                        <div>
                            <strong>{{ $dato->nombre }}</strong>
                            <small>INTENDENTE MUNICIPAL</small>
                        </div>
                    </div>

                </div>

                <div class="row g-2 mt-2">

                    <div class="col-6">
                        <button type="button" wire:click="restablecer" class="btn-final btn-imagen">
                            Reiniciar Simulacion
                        </button>
                    </div>
                </div>

                <div class="final-footer">
                    Simulador proveído por Equipo Tecnico Manuel Aguilar
                </div>

            </div>

        </div>

        @endif


</div>
