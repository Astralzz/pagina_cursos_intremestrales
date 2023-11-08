{{-- SI llego un valor ya definido --}}
@if (isset($inf_valor))
    @php
        $nombre_input = $inf_valor->nombre ?? '???';
        $region_input = [
            'valor' => $inf_valor->region->nombre ?? '???',
            'id' => $inf_valor->region->id ?? -1,
        ];
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
                <form>
                    {{-- NOMBRE Y ROL --}}
                    <div class="input-group mb-3">

                        {{-- NOMBRE --}}
                        <span class="input-group-text">Nombre completo<strong class="text-danger">*</strong></span>
                        <input required name="nombre" value="{{ isset($inf_valor) ? $nombre_input : old('nombre') }}"
                            minlength="5" maxlength="240" type="text" autocomplete="off" class="form-control"
                            aria-label="nombre">

                        {{-- ROL --}}
                        <span class="input-group-text">ROL<strong class="text-danger">*</strong></span>
                        {{-- Comprobamos si llegaron las roles_usuario --}}
                        @if (isset($roles_usuario))
                            <select name="id_rol_usuario" required class="form-select form-control"
                                aria-label=".form-select-lg example">
                                <option value="{{ isset($inf_valor) ? $rol_usuario_input['id'] : '' }}"
                                    hidden="{{ isset($inf_valor) }}" selected>
                                    {{ isset($inf_valor) ? $rol_usuario_input['valor'] : 'Selecciona un rol' }}
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
                        <input name="rfc" value="{{ isset($inf_valor) ? $rfc_input : old('rfc') }}" minlength="12"
                            maxlength="12" type="text" autocomplete="off"class="form-control" aria-label="rfc">
                        {{-- TELEFONO --}}
                        <span class="input-group-text">TELEFONO<strong class="text-danger">*</strong></span>
                        <input required name="telefono"
                            value="{{ isset($inf_valor) ? $telefono_input : old('telefono') }}" minlength="10"
                            maxlength="10" type="number" autocomplete="off" class="form-control" aria-label="telefono">
                    </div>

                    {{-- EMAIL  Y PUESTO --}}
                    <div class="input-group mb-3">
                        {{-- EMAIL --}}
                        <span class="input-group-text">EMAIL<strong class="text-danger">*</strong></span>
                        <input required name="email" value="{{ isset($inf_valor) ? $email_input : old('email') }}"
                            minlength="5" maxlength="120" type="email" autocomplete="off" class="form-control"
                            aria-label="email">
                        {{-- CLAVE PROPUESTA --}}
                        <span class="input-group-text">CLAVE PROPUESTA</span>
                        <input name="clave_propuesta"
                            value="{{ isset($inf_valor) ? $clave_p_input : old('clave_propuesta') }}" minlength="12"
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
                            value="{{ isset($inf_valor) ? $institucion_input : old('institucion') }}" minlength="5"
                            maxlength="120" type="text" autocomplete="off" class="form-control"
                            aria-label="institucion">
                        {{-- DEPARTAMENTO --}}
                        <span class="input-group-text">DEPARTAMENTO</span>
                        <input name="departamento"
                            value="{{ isset($inf_valor) ? $departamento_input : old('departamento') }}"
                            minlength="5" maxlength="120" type="text" autocomplete="off" class="form-control"
                            aria-label="departamento">
                    </div>

                    {{-- JEFE  Y HORARIO --}}
                    <div class="input-group mb-3">
                        {{-- JEFE --}}
                        <span class="input-group-text">JEFE</span>
                        <input name="nombre_jefe"
                            value="{{ isset($inf_valor) ? $nombre_jefe_input : old('nombre_jefe') }}" minlength="5"
                            maxlength="120" type="text" autocomplete="off" class="form-control"
                            aria-label="nombre_jefe">
                        {{-- HORARIO --}}
                        <span class="input-group-text">HORARIO</span>
                        <input name="horario" value="{{ isset($inf_valor) ? $horario_input : old('horario') }}"
                            minlength="5" maxlength="120" type="text" autocomplete="off" class="form-control"
                            aria-label="horario">
                    </div>

                    {{-- DOMICILIO --}}
                    <div class="input-group">
                        <span class="input-group-text">DOMICILIO</span>
                        <textarea name="domicilio" minlength="5" class="form-control" aria-label="With textarea" rows="3">@php echo isset($inf_valor) ? $domicilio_input : old('domicilio'); @endphp</textarea>
                    </div>
                </form>
            </div>



            {{-- * Boton de acceptar --}}
            <div class="modal-footer">
                <button type="button" class="btn btn-error" data-bs-dismiss="modal">Cancelar</button>
                <button class="btn btn-error" data-bs-dismiss="modal">Acceptar</button>
            </div>
        </div>
    </div>
</div>
