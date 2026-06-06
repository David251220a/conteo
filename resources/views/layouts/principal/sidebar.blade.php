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

        @can('referente.index')
            <li class="menu">
                <a href="{{route('referente.index')}}" aria-expanded="false" class="dropdown-toggle"
                    @if(Str::startsWith(Route::currentRouteName(), 'referente.index')) data-active="true" @endif
                >
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-smile"><circle cx="12" cy="12" r="10"></circle><path d="M8 14s1.5 2 4 2 4-2 4-2"></path><line x1="9" y1="9" x2="9.01" y2="9"></line><line x1="15" y1="9" x2="15.01" y2="9"></line></svg>
                        <span>Referentes</span>
                    </div>
                </a>
            </li>
        @endcan

        @can('sondeo.index')
            <li class="menu">
                <a href="{{route('sondeo.index')}}" aria-expanded="false" class="dropdown-toggle"
                    @if(Str::startsWith(Route::currentRouteName(), 'sondeo.index')) data-active="true" @endif
                >
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-globe"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                        <span>Sondeo</span>
                    </div>
                </a>
            </li>
        @endcan

        @can('sondeo.show')
            <li class="menu">
                <a href="{{route('sondeo.show')}}" aria-expanded="false" class="dropdown-toggle"
                    @if(Str::startsWith(Route::currentRouteName(), 'sondeo.show')) data-active="true" @endif
                >
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pie-chart"><path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path><path d="M22 12A10 10 0 0 0 12 2v10z"></path></svg>
                        <span>Sondeo Voto</span>
                    </div>
                </a>
            </li>
        @endcan

        @can('local.index')
            <li class="menu">
                <a href="{{route('local.index')}}" aria-expanded="false" class="dropdown-toggle"
                    @if(Str::startsWith(Route::currentRouteName(), 'local.index')) data-active="true" @endif
                >
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        <span>Locales</span>
                    </div>
                </a>
            </li>
        @endcan



        @can('vehiculo.index')
            <li class="menu">
                <a href="{{route('vehiculo.index')}}" aria-expanded="false" class="dropdown-toggle"
                    @if(Str::startsWith(Route::currentRouteName(), 'vehiculo.index')) data-active="true" @endif
                >
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                        <span>Vehiculos</span>
                    </div>
                </a>
            </li>
        @endcan

        @can('padron.index')
            <li class="menu">
                <a href="{{route('padron.index')}}" aria-expanded="false" class="dropdown-toggle"
                    @if(Str::startsWith(Route::currentRouteName(), 'padron.index')) data-active="true" @endif
                >
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                        <span>Padron</span>
                    </div>
                </a>
            </li>
        @endcan

        @can('consulta.referente')
            <li class="menu">
                <a href="{{route('consulta.referente')}}" aria-expanded="false" class="dropdown-toggle"
                    @if(Str::startsWith(Route::currentRouteName(), 'consulta.referente')) data-active="true" @endif
                >
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        <span>Consulta</span>
                    </div>
                </a>
            </li>
        @endcan

        @can('lista.index')
            <li class="menu">
                <a href="{{route('lista.index')}}" aria-expanded="false" class="dropdown-toggle"
                    @if(Str::startsWith(Route::currentRouteName(), 'lista.index')) data-active="true" @endif
                >
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-align-justify"><line x1="21" y1="10" x2="3" y2="10"></line><line x1="21" y1="6" x2="3" y2="6"></line><line x1="21" y1="14" x2="3" y2="14"></line><line x1="21" y1="18" x2="3" y2="18"></line></svg>
                        <span>Lista</span>
                    </div>
                </a>
            </li>
        @endcan

        @can('candidato.index')
            <li class="menu">
                <a href="{{route('candidato.index')}}" aria-expanded="false" class="dropdown-toggle"
                    @if(Str::startsWith(Route::currentRouteName(), 'candidato.index')) data-active="true" @endif
                >
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-check"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><polyline points="17 11 19 13 23 9"></polyline></svg>
                        <span>Candidato</span>
                    </div>
                </a>
            </li>
        @endcan

        @can('voto.intendente_manual')
            <li class="menu">
                <a href="{{route('voto.intendente_manual')}}" aria-expanded="false" class="dropdown-toggle"
                    @if(Str::startsWith(Route::currentRouteName(), 'voto.intendente_manual')) data-active="true" @endif
                >
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
                        <span>Intendente Manual</span>
                    </div>
                </a>
            </li>
        @endcan

        @can('voto.intendente_import')
            <li class="menu">
                <a href="{{route('voto.intendente_import')}}" aria-expanded="false" class="dropdown-toggle"
                    @if(Str::startsWith(Route::currentRouteName(), 'voto.intendente_import')) data-active="true" @endif
                >
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        <span>Intendente Import</span>
                    </div>
                </a>
            </li>
        @endcan

        @can('voto.consejal_manual')
            <li class="menu">
                <a href="{{route('voto.consejal_manual')}}" aria-expanded="false" class="dropdown-toggle"
                    @if(Str::startsWith(Route::currentRouteName(), 'voto.consejal_manual')) data-active="true" @endif
                >
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
                        <span>Consejal Manual</span>
                    </div>
                </a>
            </li>
        @endcan

        @can('voto.consejal_import')
            <li class="menu">
                <a href="{{route('voto.consejal_import')}}" aria-expanded="false" class="dropdown-toggle"
                    @if(Str::startsWith(Route::currentRouteName(), 'voto.consejal_import')) data-active="true" @endif
                >
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        <span>Consejal Import</span>
                    </div>
                </a>
            </li>
        @endcan

        @can('consulta.simulacion')
            <li class="menu">
                <a href="{{route('consulta.simulacion')}}" aria-expanded="false" class="dropdown-toggle"
                    @if(Str::startsWith(Route::currentRouteName(), 'consulta.simulacion')) data-active="true" @endif
                >
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shuffle"><polyline points="16 3 21 3 21 8"></polyline><line x1="4" y1="20" x2="21" y2="3"></line><polyline points="21 16 21 21 16 21"></polyline><line x1="15" y1="15" x2="21" y2="21"></line><line x1="4" y1="4" x2="9" y2="9"></line></svg>
                        <span>Consulta Simulacion</span>
                    </div>
                </a>
            </li>
        @endcan

        @can('voto.consulta_votos_carga')
            <li class="menu">
                <a href="{{route('voto.consulta_votos_carga')}}" aria-expanded="false" class="dropdown-toggle"
                    @if(Str::startsWith(Route::currentRouteName(), 'voto.consulta_votos_carga')) data-active="true" @endif
                >
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                        <span>Carga Voto</span>
                    </div>
                </a>
            </li>
        @endcan

        @can('voto.consulta_lista')
            <li class="menu">
                <a href="{{route('voto.consulta_lista')}}" aria-expanded="false" class="dropdown-toggle"
                    @if(Str::startsWith(Route::currentRouteName(), 'voto.consulta_lista')) data-active="true" @endif
                >
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-archive"><polyline points="21 8 21 21 3 21 3 8"></polyline><rect x="1" y="3" width="22" height="5"></rect><line x1="10" y1="12" x2="14" y2="12"></line></svg>
                        <span>Consulta Voto</span>
                    </div>
                </a>
            </li>
        @endcan

        @can('voto.dhondt')
            <li class="menu">
                <a href="{{route('voto.dhondt')}}" aria-expanded="false" class="dropdown-toggle"
                    @if(Str::startsWith(Route::currentRouteName(), 'voto.dhondt')) data-active="true" @endif
                >
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-cpu"><rect x="4" y="4" width="16" height="16" rx="2" ry="2"></rect><rect x="9" y="9" width="6" height="6"></rect><line x1="9" y1="1" x2="9" y2="4"></line><line x1="15" y1="1" x2="15" y2="4"></line><line x1="9" y1="20" x2="9" y2="23"></line><line x1="15" y1="20" x2="15" y2="23"></line><line x1="20" y1="9" x2="23" y2="9"></line><line x1="20" y1="14" x2="23" y2="14"></line><line x1="1" y1="9" x2="4" y2="9"></line><line x1="1" y1="14" x2="4" y2="14"></line></svg>
                        <span>D’HONDT - RESULTADO</span>
                    </div>
                </a>
            </li>
        @endcan


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
        @endcan

    </ul>

</nav>
