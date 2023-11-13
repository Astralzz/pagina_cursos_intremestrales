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
                'titulo' => 'Cursos por aceptar',
                'ruta' => route('curso.lista.admin.espera'),
            ],
        ];

        // Ruta para buscar
        $datosBuscar = [
            'titulo' => isset($titulo_buscar) ? $titulo_buscar : old('titulo_buscar') ?? '',
            'ruta' => route('curso.lista.espera.titulo'),
        ];

        // Columnas
        $listaColumnas = ['Titulo', 'Creador', 'informacion', 'Inicio', 'Final'];
        $listaVariables = ['nombre', 'usuario.nombre', 'informacion', 'fecha_inicio', 'fecha_final'];

        // Acciones
        $listaAcciones = ['ver'];

        // Acciones
        $listaAccionesAdmin = ['aceptar', 'rechazar'];
    @endphp

    @section('section_lista_cursos_publicos')
        <section class="seccion_pagina">
            @include('components.tables.tabla_cursos')
        </section>
    @endsection
@endauth
