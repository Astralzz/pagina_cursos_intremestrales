  {{-- Pagina seleccionada --}}
  <div class="col py-3 contenedor-principal">

      @auth
          {{-- Inicio --}}
          @yield('section_inicio')
          @yield('section_lista_cursos')
          @yield('section_lista_cursos_publicos')
          @yield('section_lista_usuarios_no_admin')

      @else
          <br />
          <div class="alert alert-danger">
              ERROR, No se ecncontro al ususario de la sesión actual
          </div>
      @endauth

  </div>
