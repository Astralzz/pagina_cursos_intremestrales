<div class="container">

    {{-- * Barra superior --}}
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #fff;">
        <div class="container-fluid">

            {{-- Titulo --}}
            <a class="navbar-brand" href="#">
                <img src="/imgs/logoApp.png" alt="" width="30" height="24" class="d-inline-block align-text-top">
                {{ isset($titulo) ? $titulo : 'Lista de Cursos' }}
            </a>

            {{-- Filtro --}}
            @isset($seccionesFiltro)
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="filtroSelect" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Selecciona estado
                        </a>
                        {{-- Secciones --}}
                        <ul class="dropdown-menu" aria-labelledby="filtroSelect">
                            @foreach ($seccionesFiltro as $seccion)
                            <li><a class="dropdown-item" href="{{ $seccion['ruta'] ?? '#' }}">{{ $seccion['titulo'] ??
                                    'N/A' }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
            </div>
            @endisset

            {{-- Barra de busqueda --}}
            <form class="d-flex" method="GET" action="{{ isset($datosBuscar) ? $datosBuscar['ruta'] : '#' }}">
                @csrf
                <input required name="titulo_buscar" class="form-control me-2" type="search" minlength="2"
                    maxlength="240" placeholder="Buscar titulo"
                    value="{{ isset($datosBuscar) ? $datosBuscar['titulo'] : '' }}">
                <button class="btn btn-outline-success" type="submit">Buscar</button>
            </form>

        </div>
    </nav>

    {{-- ! - Alerta de error --}}
    @if (isset($error_action_tabla) || session('error_action_tabla'))
    <div class="alert alert-danger">
        {{ $error_action_tabla ?? session('error_action_tabla') }}
    </div>
    @endif

    {{-- * - Alerta de exito --}}
    @if (isset($exito_action_tabla) || session('exito_action_tabla'))
    <div class="alert alert-success">
        {{ $exito_action_tabla ?? session('exito_action_tabla') }}
    </div>
    @endif

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

                {{-- ? Existen acciones de administrador --}}
                @isset($listaAccionesAdmin)
                @if (!empty($listaAccionesAdmin))
                {{-- ? Existe aceptar --}}
                @if (in_array('aceptar', $listaAccionesAdmin))
                <th scope="col">Aceptar</th>
                @endif
                {{-- ? Existe rechazar --}}
                @if (in_array('rechazar', $listaAccionesAdmin))
                <th scope="col">Rechazar</th>
                @endif
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
                    @if (in_array('inscribirse', $listaAcciones))
                    <a href="{{ route('inscribirse.curso.id', ['id_curso' => $curso->id, 'id_usuario' => $usuario->id]) }}" class="btn btn-outline-dark">
                        <i class="bi bi-file-earmark-plus-fill"></i>
                    </a>
                    @endif
                    {{-- ? Existe editar --}}
                    @if (in_array('editar', $listaAcciones))
                    <a href="{{ route('pre.editar.curso.id', ['id' => $curso->id ?? -1]) }}"
                        class="btn btn-outline-primary">
                        <i class="bi bi-pencil-fill"></i>
                    </a>
                    @endif
                    {{-- ? Existe eliminar --}}
                    @if (in_array('eliminar', $listaAcciones) && isset($usuario))
                    <form
                        action="{{ route('eliminar.curso.id', ['id_user' => $usuario->id, 'id_curso' => $curso->id]) }}"
                        method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            onclick="return confirm('{{ '¿Estás seguro de que quieres eliminar este curso?' }}')"
                            class="btn btn-outline-danger">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </form>
                    @endif
                </td>
                @endif
                @endisset

                {{-- ? Existen acciones de administrador --}}
                @isset($listaAccionesAdmin)
                @if (!empty($listaAccionesAdmin))
                {{-- ? Existe aceptar --}}
                @if (in_array('aceptar', $listaAccionesAdmin) && isset($usuario))
                <td>
                    <a href="{{ route('cambiar.status.curso.id', ['id_user' => $usuario->id, 'id_curso' => $curso->id, 'status' => 'ACEPTADO']) }}"
                        class="btn btn-outline-success">
                        Aceptar
                    </a>
                </td>
                @endif
                {{-- ? Existe rechazar --}}
                @if (in_array('rechazar', $listaAccionesAdmin) && isset($usuario))
                <td>
                    <a href="{{ route('cambiar.status.curso.id', ['id_user' => $usuario->id, 'id_curso' => $curso->id, 'status' => 'RECHAZADO']) }}"
                        class="btn btn-outline-danger">
                        Rechazar
                    </a>
                </td>
                @endif
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
