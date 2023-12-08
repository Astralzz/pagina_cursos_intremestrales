{{-- TODO - FORMULARIO USUARIO --}}
<div wire:ignore.self class="modal d-fade" id="modal_registro_curso" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        {{-- COMPONENTE PRINCIPAL --}}
        <div class="modal-content">
            {{-- Encabezado modal --}}
            <div class="modal-header">
                {{-- Leyenda --}}
                <h1 class="modal-title text-dark fs-5">
                    {{ isset($curso) ? 'Editar curso' : 'Registrar curso' }}
                </h1>
                {{-- ! Boton de X --}}
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>


            {{-- ? Abrir modal automaticamente --}}
            @if (session('infCursoEditar'))
            <script>
                $(document).ready(function() {
                     // Abre el modal automáticamente cuando el documento esté listo
                     $('#modal_registro_curso').modal('show');
                 });
            </script>
            @endif

            {{-- Cuerpo del modal --}}
            <div class="modal-body text-dark">

                {{-- TODO - Formulario --}}
                <form id="formulario_curso" wire:submit.prevent="{{$accionFom}}">


                    {{-- * - NOMBRE Y CATEGORIA --}}
                    <div class="input-group mb-3">
                        {{-- NOMBRE --}}
                        <span class="input-group-text">TITULO<strong class="text-danger">*</strong></span>
                        <input wire:model.lazy="nombre" type="text" class="form-control">

                        {{-- CAPASIDAD --}}
                        <label class="input-group-text" for="capacidad">CAPACIDAD<strong
                                class="text-danger">*</strong></label>
                        <select wire:model.lazy="capacidad" class="form-select">
                            <option value="" @if (isset($capacidad)) hidden @endif selected>
                                Selecionar capacidad
                            </option>
                            {{-- Asigansmos de 10 a 30 --}}
                            @for ($i = 10; $i <= 30; $i++) <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                        </select>
                    </div>

                    {{-- * - SEDE Y INSTRUCTOR --}}
                    <div class="input-group mb-3">
                        {{-- SEDE --}}
                        <span class="input-group-text">SEDE</span>
                        <input wire:model.lazy="sede" type="text" class="form-control">
                        {{-- INSTRUCTOR --}}
                        <span class="input-group-text">INSTRUCTOR<strong class="text-danger">*</strong></span>
                        <input wire:model.lazy="nombre_instructor" type="text" class="form-control">
                    </div>

                    {{-- * - TIPO Y CREADOR --}}
                    <div class="input-group mb-3">
                        {{-- TIPO --}}
                        <span class="input-group-text">TIPO<strong class="text-danger">*</strong></span>
                        <select wire:model.lazy="tipo" class="form-select form-control">
                            {{-- DEFAULD --}}
                            <option value="" @if (isset($tipo)) hidden @endif selected>
                                Selecionar tipo de curso
                            </option>
                            {{-- PRESENCIAL --}}
                            <option value="PRESENCIAL" @if (isset($tipo) && $tipo==='PRESENCIAL' ) selected @endif>
                                PRESENCIAL
                            </option>
                            {{-- VIRTUAL --}}
                            <option value="VIRTUAL" @if (isset($tipo) && $tipo==='VIRTUAL' ) selected @endif>
                                VIRTUAL
                            </option>
                        </select>
                        {{-- CREADOR --}}
                        @if (isset($usuario))
                        <span class="input-group-text">CREADOR<strong class="text-danger">*</strong></span>
                        <select wire:model.lazy="user_id" class="form-select form-control">
                            {{-- DEFAULD --}}
                            <option value="{{ $usuario->id }}" selected>
                                {{ $usuario->nombre }}
                            </option>
                        </select>
                        @endif
                    </div>

                    {{-- * - CATEGORIA Y FECHAS --}}
                    <div class="input-group mb-3">
                        {{-- CATEGORIA --}}
                        @if (isset($categorias_cursos))
                        <span class="input-group-text">CATEGORIA<strong class="text-danger">*</strong></span>
                        <select wire:model.lazy="categoria_id" class="form-select form-control">
                            {{-- DEFAULD --}}
                            <option value="" @if (isset($categoria_id)) hidden @endif selected>
                                Selecionar categoria
                            </option>
                            @foreach ($categorias_cursos as $categoria)
                            <option value="{{ $categoria->id }}" @if (isset($categoria_id) && (int)
                                $categoria_id===(int) $categoria->id) selected @endif>{{ $categoria->nombre }}
                            </option>
                            @endforeach
                        </select>
                        @endif

                        {{-- FECHA INICIO --}}
                        <span class="input-group-text">Inicio<strong class="text-danger">*</strong></span>
                        <input wire:model.lazy="fecha_inicio" type="date" class="form-control">
                        {{-- FECHA FINAL --}}
                        <span class="input-group-text">Final<strong class="text-danger">*</strong></span>
                        <input wire:model.lazy="fecha_final" type="date" class="form-control">
                    </div>

                    {{-- * - DETALLES --}}
                    <div class="input-group mb-3">
                        <span class="input-group-text">DETALLES</span>
                        <textarea wire:model.lazy="informacion" class="form-control" rows="3"></textarea>
                    </div>

                </form>

                {{-- ! Errores de validacion --}}
                @foreach ($variables as $variable)
                @error($variable)
                <div class="alert alert-danger">
                    {{ $message }}
                </div>
                @enderror
                @endforeach
            </div>
            {{-- * Botones --}}
            <div class="modal-footer">
                {{-- Cancelar --}}
                <button class="btn btn-error" data-bs-dismiss="modal">Cancelar</button>
                {{-- Aceptar --}}
                <button class="btn btn-error" form="formulario_curso">Aceptar</button>
            </div>
        </div>
    </div>

    {{-- Eventos --}}
    @section('scrips')
    <script>
        window.addEventListener('alert-swall', event => {
                Swal.fire({
                    title: event.detail[0].titulo,
                    text: event.detail[0].mensaje,
                    icon: event.detail[0].tipo
                });
            })
    </script>
    @endsection
</div>
