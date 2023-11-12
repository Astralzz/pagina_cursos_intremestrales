{{-- * heredamos --}}
@extends('index')

@auth
    {{-- * Variables por defecto --}}
    @php

        // Variable usuario
        $usuario = auth()
            ->user()
            ->load('estudios', 'cursos', 'rol');

        $ayudas = [
            [
                'titulo' => 'Manual de uso',
                'enlace' => '#',
                'icono' => 'bi bi-book-fill',
            ],
            [
                'titulo' => 'ayuda@gmail.mx',
                'enlace' => 'mailto:ayuda@gmail.mx',
                'icono' => 'bi bi-envelope-fill',
            ],
            [
                'titulo' => 'Telefono',
                'enlace' => 'tel:1234567890',
                'icono' => 'bi bi-telephone-fill',
            ],
        ];

        $datos_personales = [
            [
                'titulo' => 'Nombre',
                'dato' => $usuario->nombre ?? 'N/A',
            ],
            [
                'titulo' => 'Email',
                'dato' => $usuario->email ?? 'N/A',
            ],
            [
                'titulo' => 'Telefono',
                'dato' => $usuario->telefono ?? 'N/A',
            ],
            [
                'titulo' => 'Rol',
                'dato' => $usuario->rol->nombre ?? 'N/A',
            ],
            [
                'titulo' => 'RFC',
                'dato' => $usuario->rfc ?? 'N/A',
            ],
            [
                'titulo' => 'Clave propuesta',
                'dato' => $usuario->clave_propuesta ?? 'N/A',
            ],
            [
                'titulo' => 'Tipo de puesto',
                'dato' => $usuario->tipo_puesto ?? 'N/A',
            ],
            [
                'titulo' => 'Nivel de puesto',
                'dato' => $usuario->nivel_puesto ?? 'N/A',
            ],
            [
                'titulo' => 'Institucion',
                'dato' => $usuario->institucion ?? 'N/A',
            ],
            [
                'titulo' => 'Nombre de gefe',
                'dato' => $usuario->nombre_jefe ?? 'N/A',
            ],
            [
                'titulo' => 'Horario',
                'dato' => $usuario->horario ?? 'N/A',
            ],
            [
                'titulo' => 'Domicilio',
                'dato' => $usuario->domicilio ?? 'N/A',
            ],
        ];

        // 'licenciatura' => 'nullable|in:on,off',
        // 'maestria' => 'nullable|in:on,off',
        // 'doctorado' => 'nullable|in:on,off',
        // 'postgrado' => 'nullable|in:on,off',

    @endphp

    {{-- TODO - Seccion a poner con el id --}}
    @section('section_inicio')
        <section class="fondo-targeta">
            <div class="container py-5">

                <div class="row">

                    {{-- * - Seccion izquierda --}}
                    <div class="col-lg-4">
                        {{-- *  Parte de arriba derecha (Perfil) ------------------------- --}}
                        <div class="card mb-2">
                            <div class="card-body text-center">
                                <img src="{{ asset('imgs/logoApp.png') }}" alt="avatar" class="rounded-circle img-fluid"
                                    style="width: 150px;">
                                {{-- Nombre --}}
                                <h5 class="my-3">{{ $usuario->nombre ?? 'N/A' }}</h5>
                                {{-- Cargo --}}
                                <p class="text-muted mb-1">{{ $usuario->rol->nombre }}</p>
                            </div>
                        </div>

                        {{-- *  Parte de abajo izquierda (Ayudas) ------------------------- --}}
                        <div class="card mb-4 mb-lg-0">
                            <div class="card-body p-0">
                                <br>
                                <div class="text-center">
                                    <h6 class="my-3 rounded-3">Ayudas</h6>
                                </div>
                                {{-- * Lista de ayudas --}}
                                <ul class="list-group list-group-flush rounded-3">
                                    {{-- ? Existe ayudas? --}}
                                    @if ($ayudas)
                                        {{-- * Recorremos --}}
                                        @foreach ($ayudas as $ayuda)
                                            {{-- Ponemos el dato --}}
                                            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                                <a href="{{ $ayuda['enlace'] ?? '#' }}"
                                                    class="mb-0 text-dark text-decoration-none hover:text-primary">
                                                    {{ $ayuda['titulo'] ?? '???' }}
                                                </a>
                                                <p class="mb-0 text-dark">
                                                    <i class="{{ $ayuda['icono'] ?? '#' }}"></i>
                                                </p>
                                            </li>
                                        @endforeach
                                    @else
                                        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                            <p class="mb-0 text-danger">Error, no se pudieron obtener os datos de ayuda</p>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- * Seccion derecha --}}
                    <div class="col-lg-8">

                        {{-- *  Parte de arriba derecha (Datos personales) --}}
                        <div class="card mb-4">
                            <div class="card-body">
                                {{-- ? Existen los datos? --}}
                                @if (isset($datos_personales))
                                    {{-- * Recorremos --}}
                                    @foreach ($datos_personales as $dato)
                                        <div class="row">
                                            <div class="col-sm-3">
                                                {{-- Nombre de la seccion --}}
                                                <p class="mb-0">{{ $dato['titulo'] ?? 'desconocido' }}</p>
                                            </div>
                                            <div class="col-sm-9">
                                                {{-- Valor --}}
                                                <p class="text-muted mb-0">
                                                    {{ $dato['dato'] ?? 'desconocido' }}
                                                </p>
                                            </div>
                                        </div>
                                        <hr>
                                    @endforeach
                                @else
                                    {{-- ! Error --}}
                                    <div class="row">
                                        <div class="col-sm-7">
                                            {{-- Nombre de la seccion --}}
                                            <p class="mb-0 text-danger">Error, no se pudieron obtener los datos peronales</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    @endsection
@endauth
