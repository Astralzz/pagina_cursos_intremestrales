<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class TablaUsuariosNoAdmins extends Component
{


    // * Elementos
    public $listaUsuarios;

    // * Columnas
    public $listaColumnas = [
        'nombre', 'telefono',
        'email', 'Tipo',
        'Nivel', 'Rol',
    ];

    // * Columnas
    public $listaVariables = [
        'nombre', 'telefono',
        'email', 'tipo_puesto',
        'nivel_puesto', 'rol.nombre'
    ];

    // * Lista de usuarios no admin
    public function mount()
    {
        try {
            // Recuperar los usuarios no administradores de la base de datos
            $this->listaUsuarios = User::whereHas('rol', function ($query) {
                $query->where('is_admin', false);
            })->get();

            // ! Error
        } catch (\Throwable $th) {

            // Depuración
            logger()->error('Error al recuperar la lista de usuarios no admin: ' . $th->getMessage(), ['exception' => $th]);

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
    public function eliminarUsuario($id)
    {

        try {

            // Buscar el usuario por ID
            $usuario = User::find($id);

            // ? Existe
            if ($usuario) {
                // Eliminamos
                $usuario->delete();

                // Actualizamos lista
                $this->mount();

                // Lanzamos evento
                $this->dispatch('alert-swall', [
                    'titulo' => 'Exito',
                    'mensaje' => 'El usuario se elimino correctamente',
                    'tipo' => 'success'
                ]);

                return;
            }

            // No encontrado
            throw new \Exception('No se pudo encontrar el usuario solicitado');

            // ! Error
        } catch (\Illuminate\Database\QueryException $th) {
            // Registro del error
            logger()->error('Error al eliminar el usuario con ID ' . $id . ': ' . $th->getMessage(), ['exception' => $th]);

            // Lanzar evento
            $this->dispatch('alert-swall', [
                'titulo' => 'Error',
                'mensaje' => 'No se pudo eliminar el usuario. ' . $th->getMessage(),
                'tipo' => 'error'
            ]);
        }
    }


    // * Vista
    public function render()
    {
        return view('livewire.tabla-usuarios-no-admins');
    }
}
