<nav id="sidebar">
    <div class="shadow-bottom"></div>
    <ul class="list-unstyled menu-categories" id="accordionExample">

        <li class="menu">
            <a href="{{route('home')}}" aria-expanded="false" class="dropdown-toggle" @if(Str::startsWith(Route::currentRouteName(), 'home')) data-active="true" @endif>
                <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                    <span>Home</span>
                </div>
            </a>
        </li>

        {{-- @can('referente.index') --}}
            <li class="menu">
                <a href="{{route('referente.index')}}" aria-expanded="false" class="dropdown-toggle"
                    @if(Str::startsWith(Route::currentRouteName(), 'referente.index')) data-active="true" @endif
                >
                    <div class="">
                        <svg
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-map-pin"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <span>Referentes</span>
                    </div>
                </a>
            </li>
        {{-- @endcan --}}

        {{-- @can('local.index') --}}
            <li class="menu">
                <a href="{{route('local.index')}}" aria-expanded="false" class="dropdown-toggle"
                    @if(Str::startsWith(Route::currentRouteName(), 'local.index')) data-active="true" @endif
                >
                    <div class="">
                        <svg
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-map-pin"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <span>Locales</span>
                    </div>
                </a>
            </li>
        {{-- @endcan --}}

        {{-- @can('referente.index') --}}
            <li class="menu">
                <a href="{{route('vehiculo.index')}}" aria-expanded="false" class="dropdown-toggle"
                    @if(Str::startsWith(Route::currentRouteName(), 'vehiculo.index')) data-active="true" @endif
                >
                    <div class="">
                        <svg
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-map-pin"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <span>Vehiculos</span>
                    </div>
                </a>
            </li>
        {{-- @endcan --}}

        {{-- @can('padron.index') --}}
            <li class="menu">
                <a href="{{route('padron.index')}}" aria-expanded="false" class="dropdown-toggle"
                    @if(Str::startsWith(Route::currentRouteName(), 'padron.index')) data-active="true" @endif
                >
                    <div class="">
                        <svg
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-map-pin"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <span>Padron</span>
                    </div>
                </a>
            </li>
        {{-- @endcan --}}

        {{-- @can('consulta.index') --}}
            <li class="menu">
                <a href="{{route('consulta.referente')}}" aria-expanded="false" class="dropdown-toggle"
                    @if(Str::startsWith(Route::currentRouteName(), 'consulta.referente')) data-active="true" @endif
                >
                    <div class="">
                        <svg
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-map-pin"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <span>Consulta</span>
                    </div>
                </a>
            </li>
        {{-- @endcan --}}

        {{-- @can('lista.index') --}}
            <li class="menu">
                <a href="{{route('lista.index')}}" aria-expanded="false" class="dropdown-toggle"
                    @if(Str::startsWith(Route::currentRouteName(), 'lista.index')) data-active="true" @endif
                >
                    <div class="">
                        <svg
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-map-pin"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <span>Lista</span>
                    </div>
                </a>
            </li>
        {{-- @endcan --}}

        {{-- @can('candidato.index') --}}
            <li class="menu">
                <a href="{{route('candidato.index')}}" aria-expanded="false" class="dropdown-toggle"
                    @if(Str::startsWith(Route::currentRouteName(), 'candidato.index')) data-active="true" @endif
                >
                    <div class="">
                        <svg
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-map-pin"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <span>Candidato</span>
                    </div>
                </a>
            </li>
        {{-- @endcan --}}

        {{-- @can('voto.intendente_manual') --}}
            <li class="menu">
                <a href="{{route('voto.intendente_manual')}}" aria-expanded="false" class="dropdown-toggle"
                    @if(Str::startsWith(Route::currentRouteName(), 'voto.intendente_manual')) data-active="true" @endif
                >
                    <div class="">
                        <svg
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-map-pin"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <span>Intendente Manual</span>
                    </div>
                </a>
            </li>
        {{-- @endcan --}}

        {{-- @can('voto.consejal_manual') --}}
            <li class="menu">
                <a href="{{route('voto.consejal_manual')}}" aria-expanded="false" class="dropdown-toggle"
                    @if(Str::startsWith(Route::currentRouteName(), 'voto.consejal_manual')) data-active="true" @endif
                >
                    <div class="">
                        <svg
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-map-pin"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <span>Consejal Manual</span>
                    </div>
                </a>
            </li>
        {{-- @endcan --}}
        {{-- @can('voto.consulta_votos_carga') --}}
            <li class="menu">
                <a href="{{route('voto.consulta_votos_carga')}}" aria-expanded="false" class="dropdown-toggle"
                    @if(Str::startsWith(Route::currentRouteName(), 'voto.consulta_votos_carga')) data-active="true" @endif
                >
                    <div class="">
                        <svg
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-map-pin"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <span>Carga Voto</span>
                    </div>
                </a>
            </li>
        {{-- @endcan --}}

        {{-- @can('voto.consulta_lista') --}}
            <li class="menu">
                <a href="{{route('voto.consulta_lista')}}" aria-expanded="false" class="dropdown-toggle"
                    @if(Str::startsWith(Route::currentRouteName(), 'voto.consulta_lista')) data-active="true" @endif
                >
                    <div class="">
                        <svg
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-map-pin"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <span>Consulta Voto</span>
                    </div>
                </a>
            </li>
        {{-- @endcan --}}

        {{--
        @can('usuario.index')
            <li class="menu">
                <a href="{{route('user.index')}}" aria-expanded="false" class="dropdown-toggle"
                    @if(Str::startsWith(Route::currentRouteName(), 'user.index')) data-active="true" @endif
                >
                    <div class="">
                        <svg
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-user-check"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle>
                            <polyline points="17 11 19 13 23 9"></polyline>
                        </svg>
                        <span>Usuario</span>
                    </div>
                </a>
            </li>
        @endcan

        @can('rol.index')
            <li class="menu">
                <a href="{{route('role.index')}}" aria-expanded="false" class="dropdown-toggle"
                    @if(Str::startsWith(Route::currentRouteName(), 'role.index')) data-active="true" @endif
                >
                    <div class="">
                        <svg
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-unlock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 9.9-1"></path>
                        </svg>
                        <span>Roles</span>
                    </div>
                </a>
            </li>
        @endcan --}}

    </ul>

</nav>
