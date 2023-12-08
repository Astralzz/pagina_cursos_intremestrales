<?php

namespace App\Livewire;

use App\Models\Curso;
use Livewire\Component;

class TablaCursosInscritos extends Component
{

    // * Elementos
    public $listaCursos;

    // * Columnas
    public $listaColumnas =
    [
        'Titulo', 'Creador', 'informacion',
        'Tipo', 'Sede', 'Instructor', 'Inicio',
        'Final'
    ];

    // * Columnas
    public $listaVariables =
    [
        'nombre', 'usuario.nombre', 'informacion',
        'tipo', 'sede', 'nombre_instructor',
        'fecha_inicio', 'fecha_final'
    ];

    // Acciones
    public $listaAcciones = ['ver', 'inhabilitar'];

    public $usuario;

    // Eventos
    public $listeners = ['cursoInhabilitado'];

    public function cursoInhabilitado()
    {
        // Recargar los datos
        $this->listaCursos = $this->usuario->inscripciones;
    }

    // * Lista de usuarios no admin
    public function mount()
    {
        try {

            // Usuario
            $this->usuario = auth()->user();

            // Recuperar los cursos
            $this->listaCursos = $this->usuario->inscripciones;

            // ! Error
        } catch (\Throwable $th) {

            // Depuración
            logger()->error('Error al recuperar la lista de cursos inscritos: ' . $th->getMessage(), ['exception' => $th]);

            // Lanzamos evento
            $this->dispatch('alert-swall', [
                'titulo' => 'Error',
                'mensaje' => 'La tabla no se creo correctamente,' . $th->getMessage(),
                'tipo' => 'error'
            ]);

            // Redirigimos
            return view('index');
        }
    }

    // * Método para eliminar usuario por ID
    public function inhabilitarInscripcion($id_curso)
    {

        try {

            // Buscar el curso
            $curso = Curso::find($id_curso);

            // Verificar si el usuario está inscrito en el curso
            if ($this->usuario->inscripciones->contains($curso)) {

                // Eliminar la inscripción del usuario al curso
                $this->usuario->inscripciones()->detach($id_curso);

                // Aumentar la
                $curso->increment('capacidad');

                // Lanzar evento para actualizar la tabla
                $this->dispatch('cursoInhabilitado');

                // Lanzar evento
                $this->dispatch('alert-swall', [
                    'titulo' => 'Éxito',
                    'mensaje' => 'Te has salido del curso correctamente',
                    'tipo' => 'success'
                ]);

                return;
            }

            // No encontrado
            throw new \Exception('No se pudo encontrar la inscripcion solicitada solicitado');

            // ! Error
        } catch (\Illuminate\Database\QueryException $th) {
            // Registro del error
            logger()->error('Error al inhabilitar el curso con ID ' . $id_curso . ': ' . $th->getMessage(), ['exception' => $th]);

            // Lanzar evento
            $this->dispatch('alert-swall', [
                'titulo' => 'Error',
                'mensaje' => 'No se pudo inhabilitar el curso. ' . $th->getMessage(),
                'tipo' => 'error'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.tabla-cursos-inscritos');
    }
}
