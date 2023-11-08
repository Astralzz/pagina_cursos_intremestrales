<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Categoria_curso;
use App\Models\Rol_usuario;
use Exception;
use Illuminate\Http\Request;
use InvalidArgumentException;

//TODO - Inyección de datos desde consola
class consoleController extends Controller
{

    // * Generar todos los datos primarios
    public function generarDatosPrimariosGlobales(): void
    {
        try {

            // ! No se ejecuta desde la terminal
            if (!app()->runningInConsole()) {
                throw new InvalidArgumentException("Este evento solo puede ser ejecutado desde la consola.");
            }

            // Ejecutamos funciones de creación
            $this->generarRolesUsuarios();
            $this->generarCategoriasCursos();

            // ! Error
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 1);
        }
    }


    //SECTION -  --------- DATOS PRIMARIOS ---------

    // * Generar roles
    private function generarRolesUsuarios()
    {

        //Datos
        $datos = [
            [
                'nombre' => 'ADMINISTRADOR',
                'is_admin' => true,
            ],
            [
                'nombre' => 'GERENTE',
                'is_admin' => false,
            ],
            [
                'nombre' => 'DOCENTE',
                'is_admin' => false,
            ],
            [
                'nombre' => 'SECRETARIO',
                'is_admin' => false,
            ],
            [
                'nombre' => 'OTRO',
                'is_admin' => false,
            ],
        ];

        // Recorremos
        foreach ($datos as $data) {
            try {
                $miTabla = new Rol_usuario();
                $miTabla->nombre = $data['nombre'];
                $miTabla->is_admin = $data['is_admin'];
                $miTabla->save();
                // ! Error
            } catch (\Exception $e) {
                throw new \Exception('Error al generar rol: ' . $e->getMessage());
            }
        }

    }


    // * Generar categorias de cursos
    private function generarCategoriasCursos()
    {

        //Datos
        $datos = [
            [
                'nombre' => 'COMPUTACIÓN',
                'descripcion' => "Cursos para el area de computación",
            ],
            [
                'nombre' => 'ECONOMÍA',
                'descripcion' => "Cursos para el area de economía",
            ],
            [
                'nombre' => 'FILOSOFÍA',
                'descripcion' => "Cursos para el area de filosofía",
            ],
            [
                'nombre' => 'COCINA',
                'descripcion' => "Cursos para el area de cocina",
            ],
            [
                'nombre' => 'OTROS',
                'descripcion' => "Cursos en general",
            ],
        ];

        // Recorremos
        foreach ($datos as $data) {
            try {
                $miTabla = new Categoria_curso();
                $miTabla->nombre = $data['nombre'];
                $miTabla->descripcion = $data['descripcion'];
                $miTabla->save();
                // ! Error
            } catch (\Exception $e) {
                throw new \Exception('Error al generar rol: ' . $e->getMessage());
            }
        }
    }
}
