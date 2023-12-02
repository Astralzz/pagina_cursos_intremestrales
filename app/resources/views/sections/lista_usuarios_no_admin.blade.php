{{-- TODO, SECCION DE MIS CURSOS --}}

{{-- * heredamos --}}
@extends('index')

@auth

@section('section_lista_usuarios_no_admin')
<section class="seccion_pagina">
    {{-- Insertar el componente Livewire --}}
    @livewire('tabla-usuarios-no-admins')
</section>
@endsection
@endauth
