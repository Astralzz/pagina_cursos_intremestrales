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
                'ruta' => route('curso.lista.publica'),
            ],
        ];

        // Ruta para buscar
        $datosBuscar = [
            'titulo' => isset($titulo_buscar) ? $titulo_buscar : old('titulo_buscar') ?? '',
            'ruta' => route('curso.lista.publica.titulo'),
        ];

        // Columnas
        $listaColumnas = ['Titulo', 'informacion', 'Tipo', 'Sede', 'Instructor', 'Inicio', 'Final'];
        $listaVariables = ['nombre', 'informacion', 'tipo', 'sede', 'nombre_instructor', 'fecha_inicio', 'fecha_final'];

    @endphp

    @section('section_lista_cursos_publicos')
        <section class="seccion_pagina">
            @include('components.tables.tabla_cursos')
        </section>
    @endsection
@endauth
