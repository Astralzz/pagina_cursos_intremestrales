<div class="container">

    {{-- * Barra superior --}}
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #fff;">
        <div class="container-fluid">

            {{-- Titulo --}}
            <a class="navbar-brand" href="#">
                <img src="/imgs/logoApp.png" alt="" width="30" height="24"
                    class="d-inline-block align-text-top">
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
                                    <li><a class="dropdown-item"
                                            href="{{ $seccion['ruta'] ?? '#' }}">{{ $seccion['titulo'] ?? 'N/A' }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                </div>
            @endisset

            {{-- Barra de busqueda --}}
            <form class="d-flex" method="POST" action="{{ isset($datosBuscar) ? $datosBuscar['ruta'] : '#' }}">
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
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        {{-- ? Existen columnas --}}
                        @isset($listaColumnas)
                            @foreach ($listaColumnas as $columna)
                                <th scope="col">{{ ucfirst($columna) }}</th>
                            @endforeach
                        @endisset
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listaCursos as $curso)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>

                            {{-- ? Existe lista variables --}}
                            @isset($listaVariables)
                                {{-- Recooremos --}}
                                @foreach ($listaVariables as $variable)
                                    {{-- ? Existe --}}
                                    @if ($curso->{$variable})
                                        <td>{{ $curso->{$variable} }}</td>
                                    @endif
                                @endforeach
                            @endisset

                            <td>
                                {{-- <a href="{{ route('editar.curso', ['id' => $curso->id]) }}" class="btn btn-primary">Editar</a> --}}
                                {{-- <button class="btn btn-danger" onclick="eliminarCurso({{ $curso->id }})">Eliminar</button> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @else
        <div class="alert alert-danger">
            No ahi cursos disponibles
        </div>
    @endisset
</div>
