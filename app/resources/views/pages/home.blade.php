{{-- TODO, PAGINA PRINCIPAL DEL MENU ADMINISTRADOR --}}


{{-- ? Existe un usuario? --}}
{{-- @if (session('usuario'))
    @php
        $secciones = [
            // Noticias
            [
                'permiso' => session('usuario')->permiso_noticias,
                'titulo' => 'Noticias',
                'ref' => '#subNoticias',
                'icono' => 'bi bi-journals',
                'id' => 'subNoticias',
                'subMenu' => [
                    [
                        'titulo' => 'Nueva noticia',
                        'ruta' => route('vista.crear.noticia'),
                    ],
                    [
                        'titulo' => 'Ver mis noticias',
                        'ruta' => route('vista.tabla.admin.noticias', [
                            'id_admin' => session('usuario')->id,
                            'filas' => 10,
                        ]),
                    ],
                ],
            ],
            // Deportes
            [
                'permiso' => session('usuario')->permiso_deportes,
                'titulo' => 'Deportes',
                'ref' => '#subDeportes',
                'icono' => 'bi bi-circle',
                'id' => 'subDeportes',
                'subMenu' => [
                    [
                        'titulo' => 'Nuevo evento deportivo',
                        'ruta' => route('vista.crear.deporte'),
                    ],
                    [
                        'titulo' => 'Ver mi lista deportiva',
                        'ruta' => route('vista.tabla.admin.deportes', [
                            'id_admin' => session('usuario')->id,
                            'filas' => 10,
                        ]),
                    ],
                ],
            ],
            // Eventos
            [
                'permiso' => session('usuario')->permiso_eventos,
                'titulo' => 'Eventos',
                'ref' => '#subEventos',
                'icono' => 'bi bi-calendar-date',
                'id' => 'subEventos',
                'subMenu' => [
                    [
                        'titulo' => 'Nuevo evento',
                        'ruta' => route('vista.crear.evento'),
                    ],
                    [
                        'titulo' => 'Ver mis eventos',
                        'ruta' => route('vista.tabla.admin.eventos', ['id_admin' => session('usuario')->id, 'filas' => 10]),
                    ],
                ],
            ],
            // Culltura
            [
                'permiso' => session('usuario')->permiso_cultura,
                'titulo' => 'Cultura',
                'ref' => '#subCultura',
                'icono' => 'bi bi-palette',
                'id' => 'subCultura',
                'subMenu' => [
                    [
                        'titulo' => 'Nuevo evento cultural',
                        'ruta' => route('vista.crear.cultura'),
                    ],
                    [
                        'titulo' => 'Ver mis eventos culturales',
                        'ruta' => route('vista.tabla.admin.culturales', [
                            'id_admin' => session('usuario')->id,
                            'filas' => 10,
                        ]),
                    ],
                ],
            ],
            // Comedores
            [
                'permiso' => session('usuario')->permiso_comedores,
                'titulo' => 'Comedores',
                'ref' => '#subComedores',
                'icono' => 'bi bi-cup-straw',
                'id' => 'subComedores',
                'subMenu' => [
                    [
                        'titulo' => 'Nuevo menu',
                        'ruta' => route('vista.crear.comedor.menu'),
                    ],
                    [
                        'titulo' => 'Ver mis menus',
                        'ruta' => route('vista.tabla.admin.comedor.menu.global', [
                            'id_admin' => session('usuario')->id,
                            'filas' => 10,
                        ]),
                    ],
                ],
            ],
        ];
    @endphp
@endif --}}

{{-- * Vista -------------------------------- --}}
<div class="container-fluid vh-100">

    <div class="row flex-nowrap">

        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 menu-izquierdo">

            {{-- todo ---------------- Menu izquierdo ---------------- --}}
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">

                <br>

                {{-- * Encabezado del menu -------------------------------- --}}
                <div>
                    {{-- Imagen --}}
                    <img height="120px" alt="img" src="{{ asset('imgs/logoApp.png') }}" alt="img">
                </div>

                <br>


                {{-- *  Lista de secciones -------------------------------- --}}
                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start"
                    id="menu">

                    {{-- ? Existen las secciones --}}
                    @if (isset($secciones))

                        {{-- * Seccion del iInicio --}}
                        <li class="nav-item">
                            {{-- Enlace --}}
                            <a href="/" class="nav-link align-middle px-0 text-white">
                                {{-- Icono --}}
                                <i class="fs-4 bi-house"></i>
                                {{-- Texto --}}
                                <span class="ms-1 d-none d-sm-inline">Inicio</span>
                            </a>
                        </li>

                        {{-- * Recorremos --}}
                        @foreach ($secciones as $seccion)
                            {{-- ? Tiene permiso --}}
                            @if ($seccion['permiso'])
                                <li class="dropdown">
                                    {{-- * Encabezado  --}}
                                    <a href="{{ $seccion['ref'] ?? '#' }}"
                                        class="nav-link px-0 align-middle text-white dropdown-toggle" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        {{-- Icono --}}
                                        <i class="{{ $seccion['icono'] ?? '' }}"></i>
                                        {{-- Texto --}}
                                        <span class="ms-1 d-none d-sm-inline">{{ $seccion['titulo' ?? '????'] }}</span>
                                    </a>

                                    {{-- * Sub lista  --}}
                                    <ul class="dropdown-menu" aria-labelledby="{{ $seccion['id'] ?? '' }}">
                                        {{-- ? Tiene un sub menu? --}}
                                        @if (isset($seccion['subMenu']))
                                            {{-- Recorremos --}}
                                            @foreach ($seccion['subMenu'] as $submenu)
                                                {{-- Sub menu --}}
                                                <li>
                                                    <a href="{{ $submenu['ruta'] ?? '#' }}"
                                                        class="dropdown-item">{{ $submenu['titulo'] ?? '???' }}</a>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </li>
                            @endif
                        @endforeach

                        {{-- * Cerrar sesion --}}
                        <li>
                            <a href="{{ route('administrador.salir') }}" class="nav-link px-0 align-middle text-white">
                                <i class="bi bi-box-arrow-right"></i>
                                <span class="ms-1 d-none d-sm-inline">Cerrar sesión</span>
                            </a>
                        </li>

                    @endif

                </ul>

            </div>

        </div>

        {{-- todo ---------------- Contenido principal ---------------- --}}
        {{-- @include('recursos.elementos.cuerpo_principal') --}}
    </div>
</div>
