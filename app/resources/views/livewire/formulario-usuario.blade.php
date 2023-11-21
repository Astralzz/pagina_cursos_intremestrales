{{-- TODO -  FORMULARIO USUARIO --}}
<div wire:ignore.self class="modal d-fade" id="modal_registro_usuario" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        {{-- COMPONENTE PRINCIPAL --}}
        <div class="modal-content">
            {{-- Encabezado modal --}}
            <div class="modal-header">
                {{-- Leyenda --}}
                <h1 class="modal-title text-dark fs-5">
                    {{ isset($usuario) ? 'Editar perfil' : 'Registrar usuario' }}
                </h1>
                {{-- ! Boton de X --}}
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            {{-- Cuerpo del modal --}}
            <div class="modal-body text-dark">
                {{-- TODO - Formulario --}}
                <form id="formulario_usuario" wire:submit.prevent="guardarUsuario">
                    {{-- * - NOMBRE Y ROL --}}
                    <div class="input-group mb-3">
                        {{-- NOMBRE --}}
                        <span class="input-group-text">Nombre completo<strong class="text-danger">*</strong></span>
                        <input wire:model.lazy="nombre" type="text" class="form-control">

                        {{-- ROL --}}
                        @if (!isset($usuario))
                            <span class="input-group-text">ROL<strong class="text-danger">*</strong></span>
                            {{-- ? Llegaron roles --}}
                            @if (isset($roles_usuarios))
                                <select wire:model.lazy="rol_id" class="form-select form-control">
                                    {{-- DEFAULD --}}
                                    <option value="" @if (isset($rol_id)) hidden @endif selected>
                                        Selecionar rol
                                    </option>
                                    @foreach ($roles_usuarios as $rol_usuario)
                                        <option value="{{ $rol_usuario->id }}"
                                            @if (isset($rol_id) && (int) $rol_id === (int) $rol_usuario->id) selected @endif>{{ $rol_usuario->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                        @endif

                    </div>

                    {{-- * -RFC  Y TELEFONO --}}
                    <div class="input-group mb-3">
                        {{-- RFC --}}
                        <span class="input-group-text">RFC</span>
                        <input wire:model.lazy="rfc" type="text" maxlength="12" class="form-control">
                        {{-- TELEFONO --}}
                        <span class="input-group-text">TELEFONO<strong class="text-danger">*</strong></span>
                        <input wire:model.lazy="telefono" maxlength="10" type="text" class="form-control">
                    </div>

                    {{-- * -EMAIL Y  CLAVE PROPUESTA --}}
                    <div class="input-group mb-3">

                        {{-- EMAIL --}}
                        @if (!isset($usuario))
                            <span class="input-group-text">EMAIL<strong class="text-danger">*</strong></span>
                            <input wire:model.lazy="email" maxlength="120" type="email" class="form-control">
                        @endif
                        {{-- CLAVE PROPUESTA --}}
                        <span class="input-group-text">CLAVE PROPUESTA</span>
                        <input wire:model.lazy="clave_propuesta" maxlength="8" type="number" class="form-control">
                    </div>

                    {{-- *  - PUESTO Y NIVEL --}}
                    <div class="input-group mb-3">
                        {{-- PUESTO --}}
                        <span class="input-group-text">PUESTO<strong class="text-danger">*</strong></span>
                        <select wire:model.lazy="tipo_puesto" class="form-select form-control">
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
                        <select wire:model.lazy="nivel_puesto" class="form-select form-control">
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
                        <input wire:model.lazy="institucion" maxlength="120" type="text" class="form-control">
                        {{-- DEPARTAMENTO --}}
                        <span class="input-group-text">DEPARTAMENTO</span>
                        <input wire:model.lazy="departamento" maxlength="120" type="text" class="form-control">
                    </div>

                    {{-- * - JEFE  Y HORARIO --}}
                    <div class="input-group mb-3">
                        {{-- JEFE --}}
                        <span class="input-group-text">JEFE</span>
                        <input wire:model.lazy="nombre_jefe" maxlength="120" type="text" class="form-control">
                        {{-- HORARIO --}}
                        <span class="input-group-text">HORARIO</span>
                        <input wire:model.lazy="horario" maxlength="120" type="text" class="form-control">
                    </div>

                    {{-- * - ESTUDIOS --}}
                    <div class="input-group mb-3">
                        <span class="input-group-text">ESTUDIOS: </span>
                        {{-- Recorremos --}}
                        @foreach ($estudios_usuario as $estudio)
                            <span class="input-group-text">{{ $estudio }}</span>
                            <div class="input-group-text">
                                <input class="form-check-input mt-0" type="checkbox"
                                    wire:model.lazy="{{ $estudio }}">
                            </div>
                        @endforeach
                    </div>

                    {{-- * - DOMICILIO --}}
                    <div class="input-group mb-3">
                        <span class="input-group-text">DOMICILIO</span>
                        <textarea wire:model.lazy="domicilio" class="form-control" rows="3"></textarea>
                    </div>

                    {{-- * - CONTRASEÑAS --}}
                    <div class="input-group mb-3">
                        {{-- CONTRASEÑA --}}
                        <span class="input-group-text">Contraseña<strong class="text-danger">*</strong></span>
                        <input wire:model.lazy="password" maxlength="16" class="form-control"
                            type="{{ $mostrar_pass ? 'text' : 'password' }}">
                        <span class="input-group-text">
                            <button class="btn btn-outline-dark border" wire:click="$toggle('mostrar_pass')">
                                <i class="{{ $mostrar_pass ? 'bi bi-eye-slash-fill' : 'bi bi-eye-fill' }}"></i>
                            </button>
                        </span>
                        @if (!isset($usuario))
                            {{-- CONTRASEÑA REPETIR --}}
                            <span class="input-group-text">Repitela<strong class="text-danger">*</strong></span>
                            <input wire:model.lazy="password2" maxlength="16" type="password" class="form-control">
                            {{-- CLAVE ADMIN --}}
                            <span class="input-group-text">Clave admin</span>
                            <input wire:model.lazy="admin_key" maxlength="12" type="password" class="form-control">
                        @endif
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
                <button class="btn btn-error" form="formulario_usuario">Aceptar</button>
            </div>
        </div>
    </div>

    {{-- Eventos --}}
    @section('scrips')
        <script>
            window.addEventListener('alert-swall', event => {
                console.log(event.detail[0])
                Swal.fire({
                    title: event.detail[0].titulo,
                    text: event.detail[0].mensaje,
                    icon: event.detail[0].tipo
                });
            })
        </script>
    @endsection
</div>
