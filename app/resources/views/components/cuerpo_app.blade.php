  {{-- Pagina seleccionada --}}
  <div class="col py-3 contenedor-principal">

      @auth
          {{-- Inicio --}}
          @yield('section_inicio')
          @yield('section_lista_cursos')
          @yield('section_lista_cursos_publicos')
      @else
          <br />
          <div class="alert alert-danger">
              ERROR, No se ecncontro al ususario de la sesión actual
          </div>
      @endauth

  </div>
