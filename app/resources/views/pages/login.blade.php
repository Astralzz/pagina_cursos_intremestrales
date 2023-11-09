{{-- ESTILOS --}}
<style>
    body {
        /* Color del menu */
        background: #20e963
    }

    .boton_a {
        background-color: transparent;
        border: none;
        color: rgba(250, 250, 255, 0.5);
        text-decoration: underline;
        cursor: pointer;
    }

    .boton_a_p {
        color: rgb(250, 250, 255);
        cursor: default;
    }

    .formulario-login {
        background-color: transparent;
        border: none;
    }
</style>

{{-- CUERPO --}}
<div class="container vh-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="card shadow-2-strong formulario-login" style="border-radius: 1rem;">
                <div class="card-body p-5 text-center formulario-login">

                    {{-- * IMAGEN PRINCIPAL --}}
                    <img height="250px" alt="img" src="{{ asset('imgs/logoApp.png') }}" alt="img">

                    <br> <br>

                    {{-- TODO - LOGIN DEL SUB ADMMINISTRADOR --}}
                    <form method="POST" action="{{ route('usuario.login') }}">
                        @csrf

                        {{-- Email --}}
                        <div class="form-floating mb-3">
                            <input value="{{ old('email') }}" minlength="5" required maxlength="120" name="email"
                                type="email" autocomplete="email" class="form-control" id="email_input"
                                placeholder="nombre@example.com">
                            <label for="email_input">Email</label>
                        </div>

                        {{-- Password --}}
                        <div class="form-floating mb-3">
                            <input name="password" required minlength="8" maxlength="16" type="password"
                                class="form-control" id="input_pass" placeholder="Password">
                            <label for="input_pass">Contraseña</label>
                        </div>

                        {{-- * - Registro --}}
                        <div class="d-flex align-items-center">
                            <p class="boton_a boton_a_p">No tienes tus datos? <button type="button" class="boton_a"
                                    data-bs-toggle="modal" data-bs-target="#modal_registro_usuario">Registrate</button>
                            </p>
                        </div>

                        {{-- * - Boton de acceder --}}
                        <div class="d-grid">
                            <button class="btn btn-lg btn-danger btn-login text-uppercase fw-bold mb-2"
                                type="submit">Acceder</button>
                        </div>

                        {{-- ! - Alerta de error --}}
                        @if (session('error_login'))
                            <div class="alert alert-danger">
                                {{ session('error_login') }}
                            </div>
                        @endif

                    </form>

                    {{-- Modal del formulario --}}
                    @include('components.modals.modal_formulario_usuario')
                </div>
            </div>
        </div>
    </div>
</div>
