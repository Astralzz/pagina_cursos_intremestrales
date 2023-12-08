{{-- TODO, SECCION DE MIS CURSOS --}}

{{-- * heredamos --}}
@extends('index')

@auth

@section('section_lista_cursos-inscritos')
<section class="seccion_pagina">
    {{-- Insertar el componente Livewire --}}
    @livewire('tabla-cursos-inscritos')
</section>
@endsection
@endauth
