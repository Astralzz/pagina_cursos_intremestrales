{{-- TODO, PAGINA PRINCIPAL DEL MENU ADMINISTRADOR --}}


{{-- ? Existe un usuario? --}}
@if (isset($usuario))
    @php
        $secciones = [
            // Aceptar cursos
            [
                'permiso' => $usuario->rol->is_admin,
                'titulo' => 'Aceptar cursos',
                'ruta' => route('index'),
                'icono' => 'bi bi-journals',
            ],
            [
                'permiso' => true,
                'titulo' => 'Crear nuevo curso',
                'ruta' => route('index'),
                'icono' => 'bi bi-journals',
            ],
            [
                'permiso' => true,
                'titulo' => 'Ver mis cursos',
                'ruta' => route('index'),
                'icono' => 'bi bi-journals',
            ],
            [
                'permiso' => true,
                'titulo' => 'Ver los cursos disponibles',
                'ruta' => route('index'),
                'icono' => 'bi bi-journals',
            ],
        ];
    @endphp
@endif

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

                    <h4 class="fs-4 text-white">{{ $usuario->nombre ?? 'N/A' }}</h4>
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
                                    <a href="{{ $seccion['ruta'] ?? '#' }}"
                                        class="nav-link px-0 align-middle text-white">
                                        {{-- Icono --}}
                                        <i class="{{ $seccion['icono'] ?? '' }}"></i>
                                        {{-- Texto --}}
                                        <span class="ms-1 d-none d-sm-inline">{{ $seccion['titulo' ?? '????'] }}</span>
                                    </a>
                                </li>
                            @endif
                        @endforeach

                        {{-- * Cerrar sesion --}}
                        <li>
                            <a href="{{ route('usuario.exit') }}" class="nav-link px-0 align-middle text-white">
                                <i class="bi bi-box-arrow-right"></i>
                                <span class="ms-1 d-none d-sm-inline">Cerrar sesión</span>
                            </a>
                        </li>

                    @endif

                </ul>

            </div>

        </div>

        {{-- TODO - Contenido principal --}}
        @include('components.cuerpo_app')
    </div>
</div>
