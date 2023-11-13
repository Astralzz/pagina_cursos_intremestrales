{{-- * -  DATOS PHP --}}
@php
    // * Variables
    $variables = ['nombre', 'informacion', 'tipo', 'nombre_instructor', 'sede', 'fecha_inicio', 'fecha_final'];

    // * Recorremos
    foreach ($variables as $variable) {
        // ? Existe usaurio
        ${$variable} = session('infCurso')->$variable ?? 'N/A';
    }

    $subVariables = ['categoria', 'creador'];

    // * Recorremos
    foreach ($subVariables as $variable) {
        // ? Es creador
        if ($variable === 'creador') {
            ${$variable} = session('infCurso')->usuario->nombre ?? 'N/A';
            continue;
        }

        ${$variable} = session('infCurso')->$variable->nombre ?? 'N/A';
    }
@endphp

{{-- TODO -  FORMULARIO USUARIO --}}
<div class="modal fade" id="moodal_inf_curso" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">

        {{-- COMPONENTE PRINCIPAL --}}
        <div class="modal-content">

            {{-- Encabezado modal --}}
            <div class="modal-header">
                {{-- Leyenda --}}
                <h1 class="modal-title text-dark fs-5">
                    @if (session('infCursoTitulo'))
                        {{ session('infCursoTitulo') }}
                    @endif
                </h1>
                {{-- ! Boton de X --}}
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            {{-- Cuerpo del modal --}}
            <div class="modal-body text-dark">

                {{-- ? Abrir modal automaticamente --}}
                @if (session('infCurso'))
                    <script>
                        $(document).ready(function() {
                            $('#moodal_inf_curso').modal('show');
                        });
                    </script>

                    {{-- Crear tabla con los datos del curso --}}
                    <table class="table">
                        <tbody>
                            @foreach ($variables as $variable)
                                <tr>
                                    <th>{{ ucfirst(str_replace('_', ' ', $variable)) }}</th>
                                    <td>{{ ${$variable} }}</td>
                                </tr>
                            @endforeach

                            {{-- Recorremos subVariables --}}
                            @foreach ($subVariables as $variable)
                                <tr>
                                    <th>{{ ucfirst(str_replace('_', ' ', $variable)) }}</th>
                                    <td>{{ ${$variable} }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    {{-- Mensaje si no hay información del curso --}}
                    <p>No hay información disponible para este curso.</p>
                @endif





            </div>

            {{-- * Botones --}}
            <div class="modal-footer">
                {{-- Cancelar --}}
                <button class="btn btn-error" data-bs-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>

{{-- * Script para limpiar datos --}}
<script>
    // Limpiamos datos
    $('#moodal_inf_curso').on('hidden.bs.modal', function() {
        // Agrega acciones de limpieza aquí si es necesario
    });
</script>
