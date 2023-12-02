<div class="container">

    {{-- ? Existe lista --}}
    @isset($listaUsuarios)
    {{-- * - Tabla de usuarios --}}
    @if ($listaUsuarios->isEmpty())
    <div class="d-flex justify-content-center align-items-center h-120 container">
        <p class="text-center">La lista está vacía.</p>
    </div>
    @else
    {{-- Tabla de usuarios --}}
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

                {{-- Eliminar --}}
                <th scope="col">Eliminar</th>

            </tr>
        </thead>
        {{-- Filas --}}
        <tbody>
            @foreach ($listaUsuarios as $usuario)
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
                $subValue = $usuario;

                // Recorremos
                foreach ($subVariables as $subVariable) {
                $subValue = $subValue->{$subVariable};
                }
                @endphp

                <td>{{ $subValue }}</td>

                {{-- Dato nomal --}}
                @else
                <td>{{ data_get($usuario, $variable) ?? 'N/A' }}</td>
                @endif
                @endforeach
                @endisset

                {{-- Eliminar --}}
                <td>
                    <form wire:submit.prevent="eliminarUsuario({{$usuario->id}})">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            onclick="return confirm('{{ '¿Estás seguro de que quieres eliminar este usuario?' }}')"
                            class="btn btn-outline-danger">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </form>
                </td>


            </tr>
            @endforeach
        </tbody>

    </table>


    @endif

    @else
    <div class="alert alert-danger">
        No ahi usuarios disponibles
    </div>
    @endisset
</div>
