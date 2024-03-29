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
                'titulo' => 'Cursos publicos',
                'ruta' => route('curso.lista.publica'),
            ],
        ];

        // Ruta para buscar
        $datosBuscar = [
            'titulo' => isset($titulo_buscar) ? $titulo_buscar : old('titulo_buscar') ?? '',
            'ruta' => route('curso.lista.publica.titulo'),
        ];

            // Ruta para excel
            $datosExcel = [
            'titulo' => 'Crear Excel',
            'ruta' => route('exportar.cursos.publicos'),
        ];

        // Columnas
        $listaColumnas = ['Titulo', 'Creador', 'informacion', 'Tipo', 'Sede', 'Instructor', 'Inicio', 'Final'];
        $listaVariables = ['nombre', 'usuario.nombre', 'informacion', 'tipo', 'sede', 'nombre_instructor', 'fecha_inicio', 'fecha_final'];

        // Acciones
        $listaAcciones = ['ver', 'inscribirse'];
    @endphp

    @section('section_lista_cursos_publicos')
        <section class="seccion_pagina">
            @include('components.tables.tabla_cursos')
        </section>
    @endsection
@endauth
