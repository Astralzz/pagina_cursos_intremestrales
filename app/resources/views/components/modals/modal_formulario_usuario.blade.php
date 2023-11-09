{{-- SI llego un usario --}}
@if (isset($usuario))
    @php
        $nombre_input = $usuario->nombre ?? '???';
    @endphp
@endif


{{-- ROLES --}}
@php
    // Roles
    $roles_usuario = app('App\Http\Controllers\rolUsuarioController')->lista();
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

            {{-- Formulario --}}

            {{-- Cuerpo del modal --}}
            <div class="modal-body text-dark">

                {{-- ! Alerta de error --}}
                @if (session('error_formulario'))
                    <br />
                    <div class="alert alert-danger">
                        {{ session('error_formulario') }}
                    </div>
                @endif

                <form id="formulario_usuario" method="POST" action="{{ route('usuario.registro') }}">
                    @csrf

                    {{-- NOMBRE Y ROL --}}
                    <div class="input-group mb-3">

                        {{-- NOMBRE --}}
                        <span class="input-group-text">Nombre completo<strong class="text-danger">*</strong></span>
                        <input required name="nombre" value="{{ isset($usuario) ? $nombre_input : old('nombre') }}"
                            minlength="5" maxlength="240" type="text" autocomplete="off" class="form-control"
                            aria-label="nombre">

                        {{-- ROL --}}
                        <span class="input-group-text">ROL<strong class="text-danger">*</strong></span>
                        {{-- Comprobamos si llegaron las roles_usuario --}}
                        @if (isset($roles_usuario))
                            <select name="rol_id" required class="form-select form-control"
                                aria-label=".form-select-lg example">
                                <option value="{{ isset($usuario) ? $rol_id_input['id'] : '' }}"
                                    hidden="{{ isset($usuario) }}" selected>
                                    {{ isset($usuario) ? $rol_id_input['valor'] : 'Selecciona un rol' }}
                                </option>
                                @foreach ($roles_usuario as $rol_usuario)
                                    <option value="{{ $rol_usuario->id }}">{{ $rol_usuario->nombre }}</option>
                                @endforeach
                            </select>
                        @else
                            <br />
                            <div class="alert alert-danger">
                                ERROR, No se ecncontraron los roles de usuario
                            </div>
                        @endif
                    </div>

                    {{-- RFC  Y TELEFONO --}}
                    <div class="input-group mb-3">
                        {{-- RFC --}}
                        <span class="input-group-text">RFC</span>
                        <input name="rfc" value="{{ isset($usuario) ? $rfc_input : old('rfc') }}" minlength="12"
                            maxlength="12" type="text" autocomplete="off"class="form-control" aria-label="rfc">
                        {{-- TELEFONO --}}
                        <span class="input-group-text">TELEFONO<strong class="text-danger">*</strong></span>
                        <input required name="telefono"
                            value="{{ isset($usuario) ? $telefono_input : old('telefono') }}" minlength="10"
                            maxlength="10" type="number" autocomplete="off" class="form-control" aria-label="telefono">
                    </div>

                    {{-- EMAIL  Y PUESTO --}}
                    <div class="input-group mb-3">
                        {{-- EMAIL --}}
                        <span class="input-group-text">EMAIL<strong class="text-danger">*</strong></span>
                        <input required name="email" value="{{ isset($usuario) ? $email_input : old('email') }}"
                            minlength="5" maxlength="120" type="email" autocomplete="off" class="form-control"
                            aria-label="email">
                        {{-- CLAVE PROPUESTA --}}
                        <span class="input-group-text">CLAVE PROPUESTA</span>
                        <input name="clave_propuesta"
                            value="{{ isset($usuario) ? $clave_p_input : old('clave_propuesta') }}" minlength="12"
                            maxlength="12" type="number" autocomplete="off" class="form-control"
                            aria-label="clave_propuesta">
                    </div>

                    {{-- PUESTO Y NIVEL --}}
                    <div class="input-group mb-3">
                        {{-- PUESTO --}}
                        <span class="input-group-text">PUESTO<strong class="text-danger">*</strong></span>
                        <select required name="tipo_puesto" class="form-select form-control">
                            {{-- BASE --}}
                            <option value="BASE" selected>
                                BASE
                            </option>
                            {{-- INTERINO --}}
                            <option value="INTERINO">
                                INTERINO
                            </option>
                        </select>
                        {{-- NIVEL --}}
                        <span class="input-group-text">NIVEL<strong class="text-danger">*</strong></span>
                        <select required name="nivel_puesto" class="form-select form-control">
                            {{-- FUNCIONARIO --}}
                            <option value="FUNCIONARIO" selected>
                                FUNCIONARIO
                            </option>
                            {{-- ENLACE --}}
                            <option value="ENLACE">
                                ENLACE
                            </option>
                            {{-- OPERATIVO --}}
                            <option value="OPERATIVO">
                                OPERATIVO
                            </option>
                        </select>
                    </div>

                    {{-- INSTITUCION  Y DEPARTAMENTO --}}
                    <div class="input-group mb-3">
                        {{-- INSTITUCION --}}
                        <span class="input-group-text">INSTITUCION<strong class="text-danger">*</strong></span>
                        <input required name="institucion"
                            value="{{ isset($usuario) ? $institucion_input : old('institucion') }}" minlength="5"
                            maxlength="120" type="text" autocomplete="off" class="form-control"
                            aria-label="institucion">
                        {{-- DEPARTAMENTO --}}
                        <span class="input-group-text">DEPARTAMENTO</span>
                        <input name="departamento"
                            value="{{ isset($usuario) ? $departamento_input : old('departamento') }}" minlength="5"
                            maxlength="120" type="text" autocomplete="off" class="form-control"
                            aria-label="departamento">
                    </div>

                    {{-- JEFE  Y HORARIO --}}
                    <div class="input-group mb-3">
                        {{-- JEFE --}}
                        <span class="input-group-text">JEFE</span>
                        <input name="nombre_jefe"
                            value="{{ isset($usuario) ? $nombre_jefe_input : old('nombre_jefe') }}" minlength="5"
                            maxlength="120" type="text" autocomplete="off" class="form-control"
                            aria-label="nombre_jefe">
                        {{-- HORARIO --}}
                        <span class="input-group-text">HORARIO</span>
                        <input name="horario" value="{{ isset($usuario) ? $horario_input : old('horario') }}"
                            minlength="5" maxlength="120" type="text" autocomplete="off" class="form-control"
                            aria-label="horario">
                    </div>

                    {{-- ESTUDIOS --}}
                    <div class="input-group mb-3">
                        {{-- licenciatura --}}
                        <span class="input-group-text">licenciatura</span>
                        <div class="input-group-text">
                            <input class="form-check-input mt-0" type="checkbox" name="licenciatura"
                                id="licenciatura" {{ isset($usuario) && $usuario->licenciatura ? 'checked' : '' }}>
                        </div>
                        {{-- Maestria --}}
                        <span class="input-group-text">Maestria</span>
                        <div class="input-group-text">
                            <input class="form-check-input mt-0" type="checkbox" name="maestria" id="maestria"
                                {{ isset($usuario) && $usuario->maestria ? 'checked' : '' }}>
                        </div>
                        {{-- Doctorado --}}
                        <span class="input-group-text">Doctorado</span>
                        <div class="input-group-text">
                            <input class="form-check-input mt-0" type="checkbox" name="doctorado" id="doctorado"
                                {{ isset($usuario) && $usuario->doctorado ? 'checked' : '' }}>
                        </div>
                        {{-- Postgrado --}}
                        <span class="input-group-text">Postgrado</span>
                        <div class="input-group-text">
                            <input class="form-check-input mt-0" type="checkbox" name="postgrado" id="postgrado"
                                {{ isset($usuario) && $usuario->postgrado ? 'checked' : '' }}>
                        </div>
                    </div>

                    {{-- DOMICILIO --}}
                    <div class="input-group">
                        <span class="input-group-text">DOMICILIO</span>
                        <textarea name="domicilio" minlength="5" class="form-control" aria-label="With textarea" rows="3">@php echo isset($usuario) ? $domicilio_input : old('domicilio'); @endphp</textarea>
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
@if (!isset($usuario))
    <script>
        // Limpiamos datos
        $('#modal_registro_usuario').on('hidden.bs.modal', function() {
            $(this).find('input, select, textarea').val('').end();
        });
    </script>
@endif
