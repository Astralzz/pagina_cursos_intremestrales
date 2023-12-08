<div class="container">

    {{-- ? Existe lista --}}
    @isset($listaCursos)
    {{-- * - Tabla de cursos --}}
    @if ($listaCursos->isEmpty())
    <div class="d-flex justify-content-center align-items-center h-120 container">
        <p class="text-center">La lista está vacía.</p>
    </div>
    @else
    {{-- Tabla de cursos --}}
    <table class="table table-striped">

        {{-- Titulos --}}
        <thead>
            <tr>

                {{-- Numero --}}
                <th scope="col">No</th>

                {{-- ? Existen columnas --}}
                @isset($listaColumnas)
                @foreach ($listaColumnas as $columna)
                <th scope="col">{{ ucfirst($columna) }}</th>
                @endforeach
                @endisset

                {{-- ? Existen acciones de admin --}}
                @isset($listaAcciones)
                @if (!empty($listaAcciones))
                <th scope="col">Acciones</th>
                @endif
                @endisset

            </tr>
        </thead>
        {{-- Filas --}}
        <tbody>
            @foreach ($listaCursos as $curso)
            <tr>

                {{-- Numeracion --}}
                <th scope="row">{{ $loop->iteration }}</th>

                {{-- ? Existe lista variables --}}
                @isset($listaVariables)
                {{-- Recorremos --}}
                @foreach ($listaVariables as $variable)
                {{-- ? Existe sub dato --}}
                @if (strpos($variable, '.') !== false)
                @php
                // Acceder a subdatos
                $subVariables = explode('.', $variable);
                $subValue = $curso;

                // Recorremos
                foreach ($subVariables as $subVariable) {
                $subValue = $subValue->{$subVariable};
                }
                @endphp

                <td>{{ $subValue }}</td>

                {{-- Dato nomal --}}
                @else
                <td>{{ data_get($curso, $variable) ?? 'N/A' }}</td>
                @endif
                @endforeach
                @endisset

                {{-- ? Existen acciones --}}
                @isset($listaAcciones)
                @if (!empty($listaAcciones))
                <td>
                    {{-- ? Existe ver --}}
                    @if (in_array('ver', $listaAcciones))
                    <a href="{{ route('inf.curso.id', ['id' => $curso->id]) }}" class="btn btn-outline-dark">
                        <i class="bi bi-eye"></i>
                    </a>
                    @endif

                    @if (in_array('inhabilitar', $listaAcciones))
                    <form wire:submit.prevent="inhabilitarInscripcion({{$curso->id}})">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            onclick="return confirm('{{ '¿Estás seguro de que quieres abandonar este curso?' }}')"
                            class="btn btn-outline-danger">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </form>
                    @endif
                </td>
                @endif
                @endisset

            </tr>
            @endforeach
        </tbody>

    </table>

    {{-- Modal de infomracion --}}
    @include('components.modals.modal_informacion_curso')
    @endif
    @else
    <div class="alert alert-danger">
        No ahi cursos disponibles
    </div>
    @endisset
</div>
