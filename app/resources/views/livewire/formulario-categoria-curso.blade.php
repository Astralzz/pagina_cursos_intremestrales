{{-- TODO - FORMULARIO USUARIO --}}
<div wire:ignore.self class="modal d-fade" id="modal_registro_categoria" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        {{-- COMPONENTE PRINCIPAL --}}
        <div class="modal-content">
            {{-- Encabezado modal --}}
            <div class="modal-header">
                {{-- Leyenda --}}
                <h1 class="modal-title text-dark fs-5">
                    {{ 'Registrar categria' }}
                </h1>
                {{-- ! Boton de X --}}
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            {{-- Cuerpo del modal --}}
            <div class="modal-body text-dark">

                {{-- TODO - Formulario --}}
                <form id="formulario_categoria_curso" wire:submit.prevent="guardarCategoria">

                    {{-- * - NOMBRE Y CATEGORIA --}}
                    <div class="input-group mb-3">
                        {{-- NOMBRE --}}
                        <span class="input-group-text">NOMBRE<strong class="text-danger">*</strong></span>
                        <input wire:model.lazy="nombre" type="text" class="form-control">
                    </div>

                    {{-- * - DESCRIPCION --}}
                    <div class="input-group mb-3">
                        <span class="input-group-text">DESCRIPCION</span>
                        <textarea wire:model.lazy="descripcion" class="form-control" rows="3"></textarea>
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
                <button class="btn btn-error" form="formulario_categoria_curso">Aceptar</button>
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
