<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Categoria_curso;
use App\Models\Curso;
use App\Models\Estudios_usuario;
use App\Models\Rol_usuario;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;
use InvalidArgumentException;

//TODO - Inyección de datos desde consola
class consoleController extends Controller
{

    // * Generar todos los datos primarios
    public function generarDatosPrimariosGlobales(): void
    {
        try {

            $this->comprobarUsoConsola();

            // Ejecutamos funciones de creación
            $this->generarRolesUsuarios();
            $this->generarCategoriasCursos();

            // ! Error
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 1);
        }
    }

    // * Generar usuarios aleatorios
    public function generarUsuariosAleatorios(): void
    {
        try {

            $this->comprobarUsoConsola();

            // Ejecutamos
            $this->generarUsuariosByFaker();

            // ! Error
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 1);
        }
    }

    // * Generar cursos aleatorios
    public function generarCursosAleatorios(): void
    {
        try {

            $this->comprobarUsoConsola();

            // Ejecutamos
            $this->generarCursosByFaker();

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
                throw new \Exception('Error al generar categorias: ' . $e->getMessage());
            }
        }
    }

    // * Generar usuarios aleatorios
    private function generarUsuariosByFaker()
    {
        $faker = Faker::create();

        // Cantidad
        $cantidadUsuarios = 10;

        try {

            // Obtenemos roles
            $rolesDisponibles = Rol_usuario::pluck('id')->toArray();

            // ? Hay roles
            if (empty($rolesDisponibles)) {
                throw new \Exception('No hay roles disponibles para crear cursos.');
            }

            // Recorremos
            for ($i = 0; $i < $cantidadUsuarios; $i++) {

                // Creamos
                $nuevoUsuario = new User([
                    'nombre' => $faker->name,
                    'rol_id' => $faker->randomElement($rolesDisponibles),
                    'rfc' => $faker->optional()->regexify('[A-Z0-9]{12}'),
                    'telefono' => $faker->numerify('##########'),
                    'email' => $faker->unique()->safeEmail,
                    'clave_propuesta' => $faker->optional()->numerify('########'),
                    'tipo_puesto' => $faker->randomElement(['BASE', 'INTERNO']),
                    'nivel_puesto' => $faker->randomElement(['FUNCIONARIO', 'ENLACE', 'OPERATIVO']),
                    'institucion' => $faker->company,
                    'departamento' => $faker->optional()->word,
                    'nombre_jefe' => $faker->optional()->name,
                    'horario' => $faker->optional()->sentence,
                    'domicilio' => $faker->optional()->address,
                    'password' => Hash::make('12345678'),
                ]);

                // Guardamos
                $nuevoUsuario->save();

                // Creamos estudio
                $nuevoEstudio = new Estudios_usuario([
                    'user_id' => $nuevoUsuario->id,
                    'licenciatura' => $faker->boolean,
                    'maestria' => $faker->boolean,
                    'doctorado' => $faker->boolean,
                    'postgrado' => $faker->boolean,
                ]);

                // Guardar el estudio en la base de datos
                $nuevoEstudio->save();
            }

            // ! Error
        } catch (\Exception $e) {
            throw new \Exception('Error al generar usuario: ' . $e->getMessage());
        }
    }

    // * Generar cursos aleatorios
    private function generarCursosByFaker()
    {
        $faker = Faker::create();

        // Cantidad
        $cantidadCursos = 50;

        try {

            // Obtenemos is de usuarios
            $idsUsuarios = User::pluck('id')->toArray();
            $idsCategorias = Categoria_curso::pluck('id')->toArray();

            // ? Hay usuarios
            if (empty($idsUsuarios)) {
                throw new \Exception('No hay usuarios disponibles para crear cursos.');
            }

            // ? Hay categorias
            if (empty($idsCategorias)) {
                throw new \Exception('No hay categorias disponibles para crear cursos.');
            }

            // Recorremos
            for ($i = 0; $i < $cantidadCursos; $i++) {

                // Creamos curso con datos aleatorios
                $nuevoCurso = new Curso([
                    'user_id' =>  $faker->randomElement($idsUsuarios),
                    'categoria_id' =>  $faker->randomElement($idsCategorias),
                    'nombre' => $faker->sentence,
                    'informacion' => $faker->paragraph,
                    'tipo' => $faker->randomElement(['PRESENCIAL', 'VIRTUAL']),
                    'nombre_instructor' => $faker->name,
                    'sede' => $faker->company,
                    'fecha_inicio' => $faker->dateTimeBetween('-1 month', 'now'),
                    'fecha_final' => $faker->dateTimeBetween('now', '+3 months'),
                    'status' => $faker->randomElement(['ESPERA', 'ACEPTADO', 'RECHAZADO'])
                ]);

                // Guardamos
                $nuevoCurso->save();
            }

            // ! Error
        } catch (\Exception $e) {
            throw new \Exception('Error al generar usuario: ' . $e->getMessage());
        }
    }

    // * Comprobar que no se ejecuta en consola
    private function comprobarUsoConsola()
    {
        // ! No se ejecuta desde la terminal
        if (!app()->runningInConsole()) {
            throw new InvalidArgumentException("Este evento solo puede ser ejecutado desde la consola.");
        }
    }
}
