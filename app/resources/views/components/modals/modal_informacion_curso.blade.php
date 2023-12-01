{{-- * - DATOS PHP --}}
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

$id_curso = session('infCurso')->id ?? -1;


@endphp

{{-- TODO - FORMULARIO USUARIO --}}
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


                {{-- Alerta de error --}}
                @if(session('error_pdf'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error_pdf') }}
                </div>
                @endif

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

                {{-- Botón de descarga de PDF con estilo Bootstrap --}}
                <a class="btn btn-primary mt-3" href="{{ route('curso.generar.pdf', ['id' => $id_curso]) }}">Descargar
                    PDF</a>

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
