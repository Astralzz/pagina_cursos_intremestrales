{{-- TODO, SECCION DE MIS CURSOS --}}

{{-- * heredamos --}}
@extends('index')

@auth

    @php

        // Variable usuario
        $usuario = auth()
            ->user()
            ->load('estudios', 'cursos', 'rol');

        // Secciones del filtro
        $seccionesFiltro = [
            [
                'titulo' => 'Todos los cursos',
                'ruta' => route('curso.lista.id', ['id' => $usuario->id]),
            ],
            [
                'titulo' => 'En espera',
                'ruta' => route('curso.lista.status', ['id' => $usuario->id, 'status' => 'ESPERA']),
            ],
            [
                'titulo' => 'Aceptados',
                'ruta' => route('curso.lista.status', ['id' => $usuario->id, 'status' => 'ACEPTADO']),
            ],
            [
                'titulo' => 'Rechazados',
                'ruta' => route('curso.lista.status', ['id' => $usuario->id, 'status' => 'RECHAZADO']),
            ],
        ];

        // Ruta para buscar
        $datosBuscar = [
            'titulo' => isset($titulo_buscar) ? $titulo_buscar : old('titulo_buscar') ?? '',
            'ruta' => route('curso.lista.titulo', ['id' => $usuario->id]),
        ];

        // Secciones
        $listaColumnas = ['Titulo', 'informacion', 'Estado', 'Tipo', 'Sede', 'Instructor', 'Inicio', 'Final'];
        $listaVariables = ['nombre', 'informacion', 'status', 'tipo', 'sede', 'nombre_instructor', 'fecha_inicio', 'fecha_final'];

        // ? Filtrado
        if (isset($isFiltrado)) {
            // Eliminamos
            $listaColumnas = array_diff($listaColumnas, ['Estado']);
            $listaVariables = array_diff($listaVariables, ['status']);
        }

        // Acciones
        $listaAcciones = ['ver', 'eliminar'];

    @endphp

    @section('section_lista_cursos')
        <section class="seccion_pagina">
            @include('components.tables.tabla_cursos')
        </section>
    @endsection
@endauth
