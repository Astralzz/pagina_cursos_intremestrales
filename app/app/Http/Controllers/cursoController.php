<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Curso;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class cursoController extends Controller
{
    // * Curso
    protected $curso;

    // * Validaciones
    private $validaciones = [
        'user_id' => 'required|numeric',
        'categoria_id' => 'required|numeric',
        'nombre' => 'required|unique:cursos,nombre|string|min:5|max:240',
        'tipo' => 'nullable|in:PRESENCIAL,VIRTUAL',
        'nombre_instructor' => 'required|string|min:3|max:120',
        'sede' => 'nullable|string|min:3|max:120',
        'fecha_inicio' => 'required|date',
        'fecha_final' => 'required|date|after_or_equal:fecha_inicio',
    ];

    // * Respuestas de validaciones
    private $respuestas = [
        'user_id.required' => 'El campo creador es requerido.',
        'user_id.numeric' => 'El campo creador debe ser un número.',
        'categoria_id.required' => 'El campo categoria es requerido.',
        'categoria_id.numeric' => 'El campo categoria debe ser un número.',
        'nombre.required' => 'El campo nombre es requerido.',
        'nombre.unique' => 'El nombre proporcionado ya se encentra registrado.',
        'nombre.string' => 'El campo nombre debe ser una cadena de texto.',
        'nombre.min' => 'El campo nombre debe tener al menos 5 caracteres.',
        'nombre.max' => 'El campo nombre debe tener como máximo 240 caracteres.',
        'tipo.in' => 'El campo tipo debe ser "PRESENCIAL" o "VIRTUAL".',
        'nombre_instructor.required' => 'El campo instructor es requerido.',
        'nombre_instructor.string' => 'El campo instructor debe ser una cadena de texto.',
        'nombre_instructor.min' => 'El campo instructor debe tener al menos 5 caracteres.',
        'nombre_instructor.max' => 'El campo instructor debe tener como máximo 120 caracteres.',
        'sede.string' => 'El campo sede debe ser una cadena de texto.',
        'sede.min' => 'El campo sede debe tener al menos 3 caracteres.',
        'sede.max' => 'El campo sede debe tener como máximo 120 caracteres.',
        'fecha_inicio.required' => 'El campo fecha de inicio es requerido.',
        'fecha_inicio.date' => 'El campo fecha de inicio debe ser una fecha válida.',
        'fecha_final.required' => 'El campo fecha de inicio es requerido.',
        'fecha_final.date' => 'El campo fecha final debe ser una fecha válida.',
        'fecha_final.after_or_equal' => 'La fecha final debe ser igual o posterior a la fecha de inicio.',
    ];

    //Constructor
    public function __construct(Curso $curso)
    {
        $this->curso = $curso;
    }

    // * Registro
    public function registro(Request $request)
    {

        try {

            // Validamos
            $request->validate($this->validaciones, $this->respuestas);

            // Obtenemos el usuario autenticado
            $usuarioAutenticado = auth()->user();

            // ? No existe
            if (!$usuarioAutenticado) {
                return $this->catchErrorRegistro($request, 'El usuario autenticado no existe.');
            }

            // ? Son iguales
            if ($usuarioAutenticado->id != $request->input('user_id')) {
                return $this->catchErrorRegistro($request, 'Usuario invalido, No tienes permiso para realizar esta acción.');
            }

            // Fechas
            $fechaInicio = $request->input('fecha_inicio');
            $fechaFinal = $request->input('fecha_final');

            // ? Fechas final invalida
            if ($fechaInicio && $fechaFinal && strtotime($fechaInicio) > strtotime($fechaFinal)) {
                return $this->catchErrorRegistro($request, 'La fecha final debe ser igual o posterior a la fecha de inicio.');
            }

            // Creamos curso
            $nuevoCurso = new Curso([
                'user_id' => $request->input('user_id'),
                'categoria_id' => $request->input('categoria_id'),
                'nombre' => $request->input('nombre'),
                'tipo' => $request->input('tipo'),
                'nombre_instructor' => $request->input('nombre_instructor'),
                'sede' => $request->input('sede'),
                'fecha_inicio' => $request->input('fecha_inicio'),
                'fecha_final' => $request->input('fecha_final'),
            ]);

            // Guardamos
            $nuevoCurso->save();

            // * Éxito
            return redirect()->back()
                ->with('exito_formulario_curso', 'El curso se creo correctamente');

            // ! - Errores
        } catch (ValidationException $e) {
            return $this->catchErrorRegistro($request, 'Error de validación, ' . $e->getMessage());
        } catch (QueryException $e) {
            return $this->catchErrorRegistro($request, 'Error de query, ' . $e->getMessage());
        } catch (\Exception $e) {
            return $this->catchErrorRegistro($request, 'Error desconocido, ' . $e->getMessage());
        }
    }

    // * Editar
    public function editar(Request $request)
    {
        try {


            // Éxito
            return redirect()->back()->with('exito_formulario_curso', 'Los datos se actualizaron correctamente.');
        } catch (ValidationException $e) {
            return $this->catchErrorRegistro($request, 'Error de validación, ' . $e->getMessage());
        } catch (QueryException $e) {
            return $this->catchErrorRegistro($request, 'Error de query, ' . $e->getMessage());
        } catch (\Exception $e) {
            return $this->catchErrorRegistro($request, 'Error desconocido, ' . $e->getMessage());
        }
    }

    //SECTION - Privadas ----------------


    // ! - Error de registro
    private function catchErrorRegistro(Request $request, $mensaje)
    {
        return redirect()->back()
            ->withInput($request->only(
                'categoria_id',
                'nombre',
                'tipo',
                'nombre_instructor',
                'sede',
                'fecha_inicio',
                'fecha_final'
            ))
            ->with('error_formulario_curso', $mensaje);
    }
}
