  {{-- Pagina seleccionada --}}
  <div class="col py-3 contenedor-principal">

      {{-- Comprobamos --}}
      @if (isset($usuario))

          {{-- ! Error en una accion --}}
          @if (session('error_accion'))
              <div class="alert alert-danger">
                  {{ session('error_accion') }}
              </div>
          @endif

          @php
              //Filas de la tabla
              $filas = isset($filas) ? $filas : 10;
          @endphp

          {{-- Inicio --}}
          @yield('section_inicio')
      @else
          <br />
          <div class="alert alert-danger">
              ERROR, No se ecncontro al ususario de la sesión actual
          </div>
      @endif

  </div>
