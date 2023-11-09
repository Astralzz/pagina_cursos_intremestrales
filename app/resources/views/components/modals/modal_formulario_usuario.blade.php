{{-- * -  DATOS PHP --}}
@php
    // * Variables
    $variables = ['nombre', 'rol_id', 'rfc', 'telefono', 'email', 'clave_propuesta', 'tipo_puesto', 'nivel_puesto', 'institucion', 'departamento', 'nombre_jefe', 'horario', 'domicilio', 'licenciatura', 'maestria', 'doctorado', 'postgrado'];
    // * Recorremos
    foreach ($variables as $variable) {
        // ? Existe usaurio
        if (isset($usuario)) {
            ${$variable} = $usuario->$variable ?? null;
        } else {
            ${$variable} = old($variable) ?? null;
        }
    }

    // Roles
    $roles_usuario = app('App\Http\Controllers\rolUsuarioController')->lista();

    // Estudios
    $estudios = [
        'licenciatura' => ['nombre' => 'licenciatura', 'isCheck' => isset($licenciatura) && $licenciatura === 'on'],
        'maestria' => ['nombre' => 'maestria', 'isCheck' => isset($maestria) && $maestria === 'on'],
        'doctorado' => ['nombre' => 'doctorado', 'isCheck' => isset($doctorado) && $doctorado === 'on'],
        'postgrado' => ['nombre' => 'postgrado', 'isCheck' => isset($postgrado) && $postgrado === 'on'],
    ];

@endphp


{{-- TODO -  FORMULARIO USUARIO --}}
<div class="modal fade" id="modal_registro_usuario" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">

        {{-- COMPONENTE PRINCIPAL --}}
        <div class="modal-content">

            {{-- Encabezado modal --}}
            <div class="modal-header">
                {{-- Leyenda --}}
                <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar usuario
                </h1>
                {{-- ! Boton de X --}}
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            {{-- Cuerpo del modal --}}
            <div class="modal-body text-dark">

                {{-- ! - Alerta de error --}}
                @if (session('error_formulario'))
                    <div class="alert alert-danger">
                        {{ session('error_formulario') }}
                    </div>
                @endif

                {{-- * - Alerta de exito --}}
                @if (session('exito_formulario'))
                    <div class="alert alert-success">
                        {{ session('exito_formulario') }}
                    </div>
                @endif

                {{-- ? Abrir modal automaticamente --}}
                @if (session('error_formulario') || session('exito_formulario'))
                    <script>
                        $(document).ready(function() {
                            // Abre el modal automáticamente cuando el documento esté listo
                            $('#modal_registro_usuario').modal('show');
                        });
                    </script>
                @endif

                {{-- TODO - Formulario --}}
                <form id="formulario_usuario" method="POST" action="{{ route('usuario.registro') }}">
                    @csrf

                    {{-- * - NOMBRE Y ROL --}}
                    <div class="input-group mb-3">

                        {{-- NOMBRE --}}
                        <span class="input-group-text">Nombre completo<strong class="text-danger">*</strong></span>
                        <input required name="nombre" value="{{ isset($nombre) ? $nombre : '' }}" minlength="5"
                            maxlength="240" type="text" autocomplete="name" class="form-control" aria-label="nombre">

                        {{-- ROL --}}
                        <span class="input-group-text">ROL<strong class="text-danger">*</strong></span>
                        {{-- ? Llegaron roles --}}
                        @if (isset($roles_usuario))
                            <select name="rol_id" required class="form-select form-control">
                                {{-- DEFAULD --}}
                                <option value="" @if (isset($rol_id)) hidden @endif selected>
                                    Selecionar rol
                                </option>
                                @foreach ($roles_usuario as $rol_usuario)
                                    <option value="{{ $rol_usuario->id }}"
                                        @if (isset($rol_id) && (int) $rol_id === (int) $rol_usuario->id) selected @endif>{{ $rol_usuario->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        @endif
                    </div>

                    {{-- * -RFC  Y TELEFONO --}}
                    <div class="input-group mb-3">
                        {{-- RFC --}}
                        <span class="input-group-text">RFC</span>
                        <input name="rfc" value="{{ isset($rfc) ? $rfc : '' }}" minlength="12" maxlength="12"
                            type="text" autocomplete="additional-name" class="form-control" aria-label="rfc">
                        {{-- TELEFONO --}}
                        <span class="input-group-text">TELEFONO<strong class="text-danger">*</strong></span>
                        <input required name="telefono" value="{{ isset($telefono) ? $telefono : '' }}" minlength="10"
                            maxlength="10" type="number" autocomplete="tel" class="form-control" aria-label="telefono">
                    </div>

                    {{-- * -EMAIL Y  CLAVE PROPUESTA --}}
                    <div class="input-group mb-3">
                        {{-- EMAIL --}}
                        <span class="input-group-text">EMAIL<strong class="text-danger">*</strong></span>
                        <input required name="email" value="{{ isset($email) ? $email : '' }}" minlength="5"
                            maxlength="120" type="email" autocomplete="email" class="form-control">
                        {{-- CLAVE PROPUESTA --}}
                        <span class="input-group-text">CLAVE PROPUESTA</span>
                        <input name="clave_propuesta" value="{{ isset($clave_propuesta) ? $clave_propuesta : '' }}"
                            minlength="8" maxlength="8" type="number" autocomplete="fax" class="form-control">
                    </div>

                    {{-- *  - PUESTO Y NIVEL --}}
                    <div class="input-group mb-3">
                        {{-- PUESTO --}}
                        <span class="input-group-text">PUESTO<strong class="text-danger">*</strong></span>
                        <select required name="tipo_puesto" class="form-select form-control">
                            {{-- DEFAULD --}}
                            <option value="" @if (isset($tipo_puesto)) hidden @endif selected>
                                Selecionar tipo de puesto
                            </option>
                            {{-- BASE --}}
                            <option value="BASE" @if (isset($tipo_puesto) && $tipo_puesto === 'BASE') selected @endif>
                                BASE
                            </option>
                            {{-- INTERNO --}}
                            <option value="INTERNO" @if (isset($tipo_puesto) && $tipo_puesto === 'INTERNO') selected @endif>
                                INTERNO
                            </option>
                        </select>
                        {{-- NIVEL --}}
                        <span class="input-group-text">NIVEL<strong class="text-danger">*</strong></span>
                        <select required name="nivel_puesto" class="form-select form-control">
                            {{-- DEFAULD --}}
                            <option value="" @if (isset($nivel_puesto)) hidden @endif selected>
                                Selecionar nivel de puesto
                            </option>
                            {{-- FUNCIONARIO --}}
                            <option value="FUNCIONARIO" @if (isset($nivel_puesto) && $nivel_puesto === 'FUNCIONARIO') selected @endif>
                                FUNCIONARIO
                            </option>
                            {{-- ENLACE --}}
                            <option value="ENLACE" @if (isset($nivel_puesto) && $nivel_puesto === 'ENLACE') selected @endif>
                                ENLACE
                            </option>
                            {{-- OPERATIVO --}}
                            <option value="OPERATIVO" @if (isset($nivel_puesto) && $nivel_puesto === 'OPERATIVO') selected @endif>
                                OPERATIVO
                            </option>
                        </select>
                    </div>

                    {{-- * - INSTITUCION  Y DEPARTAMENTO --}}
                    <div class="input-group mb-3">
                        {{-- INSTITUCION --}}
                        <span class="input-group-text">INSTITUCION<strong class="text-danger">*</strong></span>
                        <input required name="institucion" value="{{ isset($institucion) ? $institucion : '' }}"
                            minlength="5" maxlength="120" type="text" autocomplete="name" class="form-control">
                        {{-- DEPARTAMENTO --}}
                        <span class="input-group-text">DEPARTAMENTO</span>
                        <input name="departamento" value="{{ isset($departamento) ? $departamento : '' }}"
                            minlength="5" maxlength="120" type="text" autocomplete="name" class="form-control">
                    </div>

                    {{-- * - JEFE  Y HORARIO --}}
                    <div class="input-group mb-3">
                        {{-- JEFE --}}
                        <span class="input-group-text">JEFE</span>
                        <input name="nombre_jefe" value="{{ isset($nombre_jefe) ? $nombre_jefe : '' }}"
                            minlength="5" maxlength="120" type="text" autocomplete="name" class="form-control">
                        {{-- HORARIO --}}
                        <span class="input-group-text">HORARIO</span>
                        <input name="horario" value="{{ isset($horario) ? $horario : '' }}" minlength="5"
                            maxlength="120" type="text" autocomplete="bday" class="form-control">
                    </div>

                    {{-- * - ESTUDIOS --}}
                    <div class="input-group mb-3">
                        <span class="input-group-text">ESTUDIOS: </span>
                        {{-- Recorremos --}}
                        @foreach ($estudios as $estudioKey => $estudioData)
                            <span class="input-group-text">{{ $estudioData['nombre'] }}</span>
                            <div class="input-group-text">
                                <input class="form-check-input mt-0" type="checkbox" name="{{ $estudioKey }}"
                                    id="{{ $estudioKey }}" @if ($estudioData['isCheck']) checked @endif>
                            </div>
                        @endforeach
                    </div>

                    {{-- * - DOMICILIO --}}
                    <div class="input-group mb-3">
                        <span class="input-group-text">DOMICILIO</span>
                        <textarea name="domicilio" minlength="5" autocomplete="home" class="form-control" aria-label="With textarea"
                            rows="3">@php echo isset($domicilio) ? $domicilio : ''; @endphp</textarea>
                    </div>

                    {{-- * - CONTRASEÑA --}}
                    <div class="input-group mb-3">
                        {{-- CONTRASEÑA --}}
                        <span class="input-group-text">Contraseña<strong class="text-danger">*</strong></span>
                        <input required name="password" inlength="8" maxlength="16" type="password"
                            class="form-control">
                        {{-- CONTRASEÑA REPETIR --}}
                        <span class="input-group-text">Repitela<strong class="text-danger">*</strong></span>
                        <input required name="password2" inlength="8" maxlength="16" type="password"
                            class="form-control">
                    </div>
                </form>
            </div>

            {{-- * Botones --}}
            <div class="modal-footer">
                {{-- Cancelar --}}
                <button class="btn btn-error" data-bs-dismiss="modal">Cancelar</button>
                {{-- Aceptar --}}
                <button class="btn btn-error" id="boton_aceptar" form="formulario_usuario">Acceptar</button>
            </div>
        </div>
    </div>
</div>

{{-- * Script para limpiar datos --}}
@if (isset($usuario))
    <script>
        // Limpiamos datos
        $('#modal_registro_usuario').on('hidden.bs.modal', function() {
            $(this).find('input, select, textarea').val('').end();
        });
    </script>
@endif
