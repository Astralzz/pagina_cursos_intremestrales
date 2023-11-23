{{-- TODO, PAGINA PRINCIPAL DEL MENU ADMINISTRADOR --}}


{{-- ? Existe un usuario? --}}
@auth

@php

// Variable usuario
$usuario = auth()
->user()
->load('estudios', 'cursos', 'rol');

$secciones = [
// Aceptar cursos
[
'permiso' => $usuario->rol->is_admin,
'titulo' => 'Cursos por aceptar',
'ruta' => route('curso.lista.admin.espera'),
'icono' => 'bi bi-exclamation-triangle-fill',
],
[
'permiso' => true,
'titulo' => 'Mis cursos',
'ruta' => route('curso.lista.id', ['id' => $usuario->id]),
'icono' => 'bi bi-person-check-fill',
],
[
'permiso' => true,
'titulo' => 'Cursos publicos',
'ruta' => route('curso.lista.publica'),
'icono' => 'bi bi-globe-americas',
],
];
@endphp

@endauth


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

                    <h4 class="fs-4 text-white">{{ isset($usuario) ? $usuario->nombre : 'N/A' }}</h4>
                </div>

                <br>

                {{-- * Lista de secciones -------------------------------- --}}
                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">

                    {{-- ? Existen las secciones --}}
                    @if (isset($secciones))

                    {{-- * Seccion del iInicio --}}
                    <li class="nav-item">
                        {{-- Enlace --}}
                        <a href="/" class="nav-link align-middle px-0 text-white">
                            {{-- Icono --}}
                            <i class="fs-4 bi-house-fill"></i>
                            {{-- Texto --}}
                            <span class="ms-1 d-none d-sm-inline">Inicio</span>
                        </a>
                    </li>


                    {{-- * Crear curso --}}
                    <li>
                        <a class="nav-link px-0 align-middle text-white" data-bs-toggle="modal"
                            data-bs-target="#modal_registro_curso">
                            <i class="bi bi-file-earmark-plus-fill"></i>
                            <span class="ms-1 d-none d-sm-inline">
                                Crear curso
                            </span>
                        </a>
                    </li>

                    {{-- Modal del formulario usuario --}}
                    {{-- @include('components.modals.modal_formulario_curso') --}}

                    {{-- Modal del formulario con livewire --}}
                    <livewire:formulario-cursos  />

                    {{-- * Recorremos --}}
                    @foreach ($secciones as $seccion)
                    {{-- ? Tiene permiso --}}
                    @if ($seccion['permiso'])
                    <li class="dropdown">
                        {{-- * Encabezado --}}
                        <a href="{{ $seccion['ruta'] ?? '#' }}" class="nav-link px-0 align-middle text-white">
                            {{-- Icono --}}
                            <i class="{{ $seccion['icono'] ?? '' }}"></i>
                            {{-- Texto --}}
                            <span class="ms-1 d-none d-sm-inline">{{ $seccion['titulo' ?? '????'] }}</span>
                        </a>
                    </li>
                    @endif
                    @endforeach

                    {{-- * Modificar peril --}}
                    <li>
                        <a class="nav-link px-0 align-middle text-white" data-bs-toggle="modal"
                            data-bs-target="#modal_registro_usuario">
                            <i class="bi bi-pencil-fill"></i>
                            <span class="ms-1 d-none d-sm-inline">
                                Modificar perfil</span>
                        </a>
                    </li>

                    {{-- Modal del formulario usuario --}}
                    {{-- @include('components.modals.modal_formulario_usuario') --}}

                    {{-- Modal del formulario con livewire --}}
                    <livewire:formulario-usuario />

                    @endif

                    {{-- * Cerrar sesion --}}
                    <li>
                        <a href="{{ route('usuario.exit') }}" class="nav-link px-0 align-middle text-white">
                            <i class="bi bi-box-arrow-right"></i>
                            <span class="ms-1 d-none d-sm-inline">Cerrar sesión</span>
                        </a>
                    </li>

                </ul>

            </div>

        </div>

        {{-- TODO - Contenido principal --}}
        @include('components.cuerpo_app')
    </div>
</div>
