{{-- * -  DATOS PHP --}}
@php
    // * Variables
    $variables = ['categoria_id', 'nombre', 'informacion', 'tipo', 'nombre_instructor', 'sede', 'fecha_inicio', 'fecha_final'];

    // * Recorremos
    foreach ($variables as $variable) {
        // ? Existe usaurio
        if (session('infCursoEditar')) {
            ${$variable} = session('infCursoEditar')->$variable ?? null;
        } else {
            ${$variable} = old($variable) ?? null;
        }
    }

    // Categorias
    $categorias_cursos = app('App\Http\Controllers\categoriaCursoController')->lista();

    // Accion
    $Accion_form = session('infCursoEditar') ? route('curso.editar', ['id' => session('infCursoEditar')->id]) : route('curso.registro');

@endphp


{{-- TODO -  FORMULARIO USUARIO --}}
<div class="modal fade" id="modal_registro_curso" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">

        {{-- COMPONENTE PRINCIPAL --}}
        <div class="modal-content">

            {{-- Encabezado modal --}}
            <div class="modal-header">
                {{-- Leyenda --}}
                <h1 class="modal-title text-dark fs-5">
                    {{ session('infCursoEditar') ? 'Editar curso' : 'Registrar curso' }}
                </h1>
                {{-- ! Boton de X --}}
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            {{-- Cuerpo del modal --}}
            <div class="modal-body text-dark">

                {{-- ! - Alerta de error --}}
                @if (session('error_formulario_curso'))
                    <div class="alert alert-danger">
                        {{ session('error_formulario_curso') }}
                    </div>
                @endif

                {{-- * - Alerta de exito --}}
                @if (session('exito_formulario_curso'))
                    <div class="alert alert-success">
                        {{ session('exito_formulario_curso') }}
                    </div>
                @endif

                {{-- ? Abrir modal automaticamente --}}
                @if (session('error_formulario_curso') || session('exito_formulario_curso') || session('infCursoEditar'))
                    <script>
                        $(document).ready(function() {
                            // Abre el modal automáticamente cuando el documento esté listo
                            $('#modal_registro_curso').modal('show');
                        });
                    </script>
                @endif

                {{-- TODO - Formulario --}}
                <form id="formulario_curso" method="POST" action="{{ $Accion_form }}">
                    @csrf

                    {{-- * - NOMBRE Y CATEGORIA --}}
                    <div class="input-group mb-3">
                        {{-- NOMBRE --}}
                        <span class="input-group-text">Titulo<strong class="text-danger">*</strong></span>
                        <input required name="nombre" value="{{ isset($nombre) ? $nombre : '' }}" minlength="5"
                            maxlength="240" type="text" autocomplete="name" class="form-control">
                    </div>

                    {{-- * - SEDE  Y INSTRUCTOR --}}
                    <div class="input-group mb-3">
                        {{-- SEDE --}}
                        <span class="input-group-text">SEDE</span>
                        <input name="sede" value="{{ isset($sede) ? $sede : '' }}" minlength="3" maxlength="120"
                            type="text" autocomplete="additional-name" class="form-control">
                        {{-- INSTRUCTOR --}}
                        <span class="input-group-text">INSTRUCTOR<strong class="text-danger">*</strong></span>
                        <input required name="nombre_instructor"
                            value="{{ isset($nombre_instructor) ? $nombre_instructor : '' }}" minlength="3"
                            maxlength="120" type="text" autocomplete="additional-name" class="form-control">
                    </div>

                    {{-- *  - TIPO Y CREADOR --}}
                    <div class="input-group mb-3">
                        {{-- TIPO --}}
                        <span class="input-group-text">TIPO<strong class="text-danger">*</strong></span>
                        <select required name="tipo" class="form-select form-control">
                            {{-- DEFAULD --}}
                            <option value="" @if (isset($tipo)) hidden @endif selected>
                                Selecionar tipo de curso
                            </option>
                            {{-- PRESENCIAL --}}
                            <option value="PRESENCIAL" @if (isset($tipo) && $tipo === 'PRESENCIAL') selected @endif>
                                PRESENCIAL
                            </option>
                            {{-- VIRTUAL --}}
                            <option value="VIRTUAL" @if (isset($tipo) && $tipo === 'VIRTUAL') selected @endif>
                                VIRTUAL
                            </option>
                        </select>
                        {{-- CREADOR --}}
                        @if (isset($usuario))
                            <span class="input-group-text">CREADOR<strong class="text-danger">*</strong></span>
                            <select required name="user_id" class="form-select form-control">
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
                            <select name="categoria_id" required class="form-select form-control">
                                {{-- DEFAULD --}}
                                <option value="" @if (isset($categoria_id)) hidden @endif selected>
                                    Selecionar categoria
                                </option>
                                @foreach ($categorias_cursos as $categoria)
                                    <option value="{{ $categoria->id }}"
                                        @if (isset($categoria_id) && (int) $categoria_id === (int) $categoria->id) selected @endif>{{ $categoria->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        @endif
                        {{-- FECHA  INICIO --}}
                        <span class="input-group-text">Inicio<strong class="text-danger">*</strong></span>
                        <input required name="fecha_inicio" type="date" class="form-control"
                            value="{{ isset($fecha_inicio) ? $fecha_inicio : '' }}">
                        {{-- FECHA  FINAL --}}
                        <span class="input-group-text">Final<strong class="text-danger">*</strong></span>
                        <input required name="fecha_final" type="date" class="form-control"
                            value="{{ isset($fecha_final) ? $fecha_final : '' }}">
                    </div>

                    {{-- * - DOMICILIO --}}
                    <div class="input-group mb-3">
                        <span class="input-group-text">DOMICILIO</span>
                        <textarea name="informacion" minlength="5" autocomplete="home" class="form-control" rows="3">@php echo isset($informacion) ? $informacion : ''; @endphp</textarea>
                    </div>

                </form>
            </div>

            {{-- * Botones --}}
            <div class="modal-footer">
                {{-- Cancelar --}}
                <button class="btn btn-error" data-bs-dismiss="modal">Cancelar</button>
                {{-- Aceptar --}}
                <button class="btn btn-error" form="formulario_curso">Acceptar</button>
            </div>
        </div>
    </div>
</div>

{{-- * Script para limpiar datos --}}
@if (false)
    <script>
        // Limpiamos datos
        $('#modal_registro_curso').on('hidden.bs.modal', function() {
            $(this).find('input, select, textarea').val('').end();
        });
    </script>
@endif
