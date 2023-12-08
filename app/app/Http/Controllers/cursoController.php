<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Curso;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class cursoController extends Controller
{
    // * Curso
    protected $curso;

    // * Validaciones
    private $validaciones = [
        'user_id' => 'required|numeric',
        'categoria_id' => 'required|numeric',
        'nombre' => 'required|unique:cursos,nombre|string|min:5|max:240',
        'informacion' => 'nullable|string|min:5',
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
        'informacion.string' => 'El campo informacion debe ser una cadena de texto.',
        'informacion.min' => 'El campo informacion debe tener al menos 5 caracteres.',
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

            // ? Son diferentes
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
            $this->curso->create([
                'user_id' => $request->input('user_id'),
                'categoria_id' => $request->input('categoria_id'),
                'nombre' => $request->input('nombre'),
                'informacion' => $request->input('informacion'),
                'tipo' => $request->input('tipo'),
                'nombre_instructor' => $request->input('nombre_instructor'),
                'sede' => $request->input('sede'),
                'fecha_inicio' => $request->input('fecha_inicio'),
                'fecha_final' => $request->input('fecha_final'),
            ]);

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
    public function editar(Request $request, $id)
    {
        try {

            // Reglas sin nombre único
            $reglasValidacion = $this->validaciones;
            $reglasValidacion['nombre'] = 'required|string|min:5|max:240';
            $respuestasValidacion = $this->respuestas;
            unset($respuestasValidacion['nombre.unique']);

            // Validamos
            $request->validate($reglasValidacion, $respuestasValidacion);

            // Obtenemos el usuario autenticado
            $usuarioAutenticado = auth()->user();

            // ? No existe
            if (!$usuarioAutenticado) {
                return $this->catchErrorRegistro($request, 'El usuario autenticado no existe.');
            }

            // ? Son diferentes
            if ($usuarioAutenticado->id != $request->input('user_id')) {
                return $this->catchErrorRegistro($request, 'Usuario invalido, No tienes permiso para realizar esta acción.');
            }

            // Fechas
            $fechaInicio = $request->input('fecha_inicio');
            $fechaFinal = $request->input('fecha_final');

            // ? Fechas final inválida
            if ($fechaInicio && $fechaFinal && strtotime($fechaInicio) > strtotime($fechaFinal)) {
                return $this->catchErrorRegistro($request, 'La fecha final debe ser igual o posterior a la fecha de inicio.');
            }

            // Buscamos
            $curso = $this->curso->findOrFail($id);

            // Actualizamos
            $curso->update([
                'categoria_id' => $request->input('categoria_id'),
                'nombre' => $request->input('nombre'),
                'informacion' => $request->input('informacion'),
                'tipo' => $request->input('tipo'),
                'nombre_instructor' => $request->input('nombre_instructor'),
                'sede' => $request->input('sede'),
                'fecha_inicio' => $request->input('fecha_inicio'),
                'fecha_final' => $request->input('fecha_final'),
            ]);


            // Éxito
            return redirect()->back()->with('exito_action_tabla', 'Los datos se actualizaron correctamente.');
        } catch (ValidationException $e) {
            return $this->catchErrorRegistro($request, 'Error de validación, ' . $e->getMessage());
        } catch (QueryException $e) {
            return $this->catchErrorRegistro($request, 'Error de query, ' . $e->getMessage());
        } catch (\Exception $e) {
            return $this->catchErrorRegistro($request, 'Error desconocido, ' . $e->getMessage());
        }
    }

    // * Ver curso por id
    public function infCursoPorId($id)
    {
        try {

            // Buscamos
            $curso = $this->curso->findOrFail($id);

            // Devolver la vista con el curso
            return redirect()->back()->with([
                'infCurso' => $curso,
                'infCursoTitulo' => 'Detalle del curso ' . $curso->nombre,
            ]);
        } catch (\Exception $e) {
            return back()->with('error_action_tabla', 'Error al ver curso, ' . $e->getMessage());
        }
    }


    // * Inscribirse al curso por id
    public function inscripcionCurso($id_curso, $id_usuario)
    {
        try {

            // Buscar el curso
            $curso = Curso::findOrFail($id_curso);

            // Verificar si hay capacidad disponible
            if ($curso->capacidad <= 0) {
                throw new \Exception('No hay capacidad disponible para inscribirse en este curso.');
            }

            // Obtener el usuario
            $usuario = auth()->user();

            // Verificar si el usuario ya está inscrito en este curso
            if ($curso->usuariosInscritos->contains($usuario)) {
                throw new \Exception('Ya estás inscrito en este curso.');
            }

            // Decrementar la capacidad del curso en 1
            $curso->decrement('capacidad');

            // Relacionar usuario con curso
            $curso->usuariosInscritos()->attach($usuario->id);
            // Devolver exito
            return redirect()->back()->with('exito_action_tabla', 'Exito, Te has inscrito en el curso correctamente el curso correctamente');
        } catch (\Exception $e) {
            return back()->with('error_action_tabla', 'Error al inscribirse al curso, ' . $e->getMessage());
        }
    }

    // * Pre editar curso por id
    public function preEditarCursoPorId($id)
    {
        try {

            // Buscamos
            $curso = $this->curso->findOrFail($id);

            // Devolver la vista con el curso
            return redirect()->back()->with([
                'infCursoEditar' => $curso,
            ]);
        } catch (\Exception $e) {
            return back()->with('error_action_tabla', 'Error al editar curso, ' . $e->getMessage());
        }
    }

    // * Eliminar por id
    public function eliminarCursoPorId($id_user, $id_curso)
    {
        try {

            // ? Son diferentes
            if (auth()->id() != $id_user) {
                throw new \Exception('No tienes autorización para eliminar este curso');
            }

            // Buscamos
            $curso = $this->curso->findOrFail($id_curso);

            // Eliminamos
            $curso->delete();

            // Devolver exito
            return redirect()->back()->with('exito_action_tabla', 'Exito, Se elimino el curso correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error_action_tabla', 'Error al eliminar curso, ' . $e->getMessage());
        }
    }

    // * Cambiar status por id
    public function actualizarStatusCurso($id_user, $id_curso, $status)
    {
        try {

            // ? Son diferentes
            if (auth()->id() != $id_user) {
                throw new \Exception('No tienes autorización para eliminar este curso');
            }

            // Obtenemos el usuario autenticado
            $usuarioAutenticado =  auth()->user();

            // ? No existe
            if (!$usuarioAutenticado) {
                throw new \Exception('No se encontró un usuario activo');
            }

            // Obtenemos el rol del usuario
            $rolUsuario = $usuarioAutenticado->rol;

            // ? No se tiene permiso
            if (!$rolUsuario || $rolUsuario->is_admin !== 1) {
                throw new \Exception('No tienes permiso, solo los administradores pueden acceder a esta esta opción');
            }

            // ? Opción no vaída
            if ($status != "ACEPTADO" && $status != "RECHAZADO") {
                throw new \Exception('El status es incorrecto, solo se admite ACEPTADO o RECHAZADO');
            }

            // Buscamos
            $curso = $this->curso->findOrFail($id_curso);

            // Actualizamos
            $curso->update([
                'status' => $status,
            ]);

            // Devolver exito
            return redirect()->back()->with('exito_action_tabla', 'Exito, el curso se actualizo correctamente');

            // ! Eliminar
        } catch (\Exception $e) {
            return redirect()->back()->with('error_action_tabla', 'Error al actualizar estatus, ' . $e->getMessage());
        }
    }

    // * Lista por id
    public function listaPorId($id)
    {
        try {

            // ? Son diferentes
            if (auth()->id() != $id) {
                throw new \Exception('No tienes autorización para ver esta lista');
            }

            // Obtenemos
            $lista = $this->curso->where('user_id', $id)->get();

            // Devolver la vista con la lista de cursos del usuario
            return view('sections.lista_cursos', [
                'listaCursos' => $lista,
                'titulo' => 'Todos mis cursos',
            ]);

            // ! - error
        } catch (\Exception $e) {
            return view('sections.lista_cursos')
                ->with('error_action_tabla', 'Error al obtener la lista de cursos, ' . $e->getMessage());
        }
    }

    // * Lista publica
    public function listaPublica()
    {
        try {

            // Obtenemos aceptados
            $lista = $this->curso
                ->with([
                    'usuario:id,nombre',
                    'categoria:id,nombre'
                ])
                ->where('status', 'ACEPTADO')
                ->select([
                    'id',
                    'nombre',
                    'informacion',
                    'tipo',
                    'nombre_instructor',
                    'sede',
                    'fecha_inicio',
                    'fecha_final',
                    'user_id',
                    'categoria_id'
                ])
                ->get();

            // Devolver la vista con la lista de cursos del usuario
            return view('sections.lista_cursos_publicos', [
                'listaCursos' => $lista,
                'titulo' => 'Todos los cursos',
            ]);

            // ! - error
        } catch (\Exception $e) {
            return view('sections.lista_cursos_publicos')
                ->with('error_action_tabla', 'Error al obtener la lista de cursos, ' . $e->getMessage());
        }
    }

    // * Lista publica
    public function listaInscritos()
    {
        return view('sections.lista-cursos-inscritos');
    }

    // * Lista por aceptar
    public function listaPorAceptar()
    {
        try {

            // Obtenemos el usuario autenticado
            $usuarioAutenticado =  auth()->user();

            // ? No existe
            if (!$usuarioAutenticado) {
                throw new \Exception('No se encontró un usuario activo');
            }

            // Obtenemos el rol del usuario
            $rolUsuario = $usuarioAutenticado->rol;

            // ? No se tiene permiso
            if (!$rolUsuario || $rolUsuario->is_admin !== 1) {
                throw new \Exception('No tienes permiso, solo los administradores pueden ver esta sección');
            }

            // Obtenemos aceptados
            $lista = $this->curso
                ->with([
                    'usuario:id,nombre',
                    'categoria:id,nombre'
                ])
                ->where('status', 'ESPERA')
                ->select([
                    'id',
                    'nombre',
                    'informacion',
                    'tipo',
                    'nombre_instructor',
                    'sede',
                    'fecha_inicio',
                    'fecha_final',
                    'user_id',
                    'categoria_id'
                ])
                ->get();

            // Devolver la vista con la lista de cursos del usuario
            return view('sections.lista_cursos_por_aceptar', [
                'listaCursos' => $lista,
                'titulo' => 'Cursos por aceptar',
            ]);

            // ! - error
        } catch (\Exception $e) {
            return view('sections.lista_cursos_por_aceptar')
                ->with('error_action_tabla', 'Error al obtener la lista de cursos, ' . $e->getMessage());
        }
    }

    // * Lista por status
    public function listaPorStatus($id, $status)
    {
        try {

            // ? Son diferentes
            if (auth()->id() != $id) {
                throw new \Exception('No tienes autorización para ver esta lista');
            }

            // Obtenemos
            $lista = $this->curso->where('user_id', $id)
                ->where('status', $status)
                ->get();

            // Titulo
            $titulo = 'Cursos ' . ($status != 'ESPERA' ? strtolower($status) . 's' : 'en espera');

            // Devolver la vista con la lista de cursos del usuario
            return view('sections.lista_cursos', [
                'listaCursos' => $lista,
                'isFiltrado' => '1',
                'titulo' => $titulo,
            ]);

            // ! - error
        } catch (\Exception $e) {
            return view('sections.lista_cursos')
                ->with('error_action_tabla', 'Error al obtener la lista de cursos, ' . $e->getMessage());
        }
    }

    // * Lista por titulo
    public function listaPorTitulo($id, Request $request)
    {
        try {

            // Validamos
            $request->validate(
                [
                    'titulo_buscar' => 'required|string|min:2|max:240'
                ],
                [
                    'titulo_buscar.required' => 'El campo titulo es requerido.',
                    'titulo_buscar.string' => 'El campo titulo debe ser una cadena de texto.',
                    'titulo_buscar.min' => 'El campo titulo debe tener al menos 2 caracteres.',
                    'titulo_buscar.max' => 'El campo titulo debe tener como máximo 240 caracteres.',
                ]
            );

            // ? Son diferentes
            if (auth()->id() != $id) {
                throw new \Exception('No tienes autorización para ver esta lista');
            }

            // Obtenemos
            $lista = $this->curso->where('user_id', $id)
                ->where('nombre', 'like', '%' . $request->input('titulo_buscar') . '%')
                ->get();

            // Devolver la vista con la lista de cursos del usuario
            return view('sections.lista_cursos', [
                'listaCursos' => $lista,
                'titulo' => 'Todos mis cursos',
                'titulo_buscar' => $request->input('titulo_buscar'),
            ]);

            // ! - error
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput($request->only(
                    'titulo_buscar',
                ))
                ->with('error_action_tabla', 'Error al obtener la lista de cursos, ' . $e->getMessage());
        }
    }

    // * Lista publica por titulo
    public function listaPublicaPorTitulo(Request $request)
    {
        try {

            // Validamos
            $request->validate(
                [
                    'titulo_buscar' => 'required|string|min:2|max:240'
                ],
                [
                    'titulo_buscar.required' => 'El campo titulo es requerido.',
                    'titulo_buscar.string' => 'El campo titulo debe ser una cadena de texto.',
                    'titulo_buscar.min' => 'El campo titulo debe tener al menos 2 caracteres.',
                    'titulo_buscar.max' => 'El campo titulo debe tener como máximo 240 caracteres.',
                ]
            );

            // Obtenemos
            $lista = $this->curso->where('status', 'ACEPTADO')
                ->where('nombre', 'like', '%' . $request->input('titulo_buscar') . '%')
                ->get();

            // Devolver la vista con la lista de cursos del usuario
            return view('sections.lista_cursos_publicos', [
                'listaCursos' => $lista,
                'titulo' => 'Cursos publicos',
                'titulo_buscar' => $request->input('titulo_buscar'),
            ]);

            // ! - Error
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput($request->only(
                    'titulo_buscar',
                ))
                ->with('error_action_tabla', 'Error al obtener la lista de cursos, ' . $e->getMessage());
        }
    }

    // * Lista por aceptar titulo
    public function listaPorAceptarPorTitulo(Request $request)
    {
        try {

            // Validamos
            $request->validate(
                [
                    'titulo_buscar' => 'required|string|min:2|max:240'
                ],
                [
                    'titulo_buscar.required' => 'El campo titulo es requerido.',
                    'titulo_buscar.string' => 'El campo titulo debe ser una cadena de texto.',
                    'titulo_buscar.min' => 'El campo titulo debe tener al menos 2 caracteres.',
                    'titulo_buscar.max' => 'El campo titulo debe tener como máximo 240 caracteres.',
                ]
            );

            // Obtenemos
            $lista = $this->curso->where('status', 'ESPERA')
                ->where('nombre', 'like', '%' . $request->input('titulo_buscar') . '%')
                ->get();

            // Devolver la vista con la lista de cursos del usuario
            return view('sections.lista_cursos_por_aceptar', [
                'listaCursos' => $lista,
                'titulo' => 'Cursos por aceptar',
                'titulo_buscar' => $request->input('titulo_buscar'),
            ]);

            // ! - Error
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput($request->only(
                    'titulo_buscar',
                ))
                ->with('error_action_tabla', 'Error al obtener la lista de cursos, ' . $e->getMessage());
        }
    }

    // * Crear pdf
    public function crearPdf($id)
    {
        try {
            // Obtener el curso con el ID proporcionado
            $curso = $this->curso->find($id);

            // ? Existe
            if (!$curso) {
                return redirect()->back()->with('error_pdf', 'No se encontró el curso con el ID proporcionado.');
            }

            // Variables
            $variables = ['nombre', 'informacion', 'tipo', 'nombre_instructor', 'sede', 'fecha_inicio', 'fecha_final'];
            $subVariables = ['categoria'];

            $datosCurso = [];

            // Obtenemos datos primarios
            foreach ($variables as $variable) {
                $datosCurso[$variable] = $curso->{$variable} ?? "N/A";
            }

            // Obtenemos datos secundarios
            foreach ($subVariables as $variable) {
                // Verificar si la relación está definida y no es nula
                if ($curso->{$variable}) {
                    $datosCurso[$variable] = $curso->{$variable}->nombre;
                } else {
                    // Si la relación es nula, puedes manejarlo de alguna manera
                    $datosCurso[$variable] = 'N/A';
                }
            }

            $datosCurso['creador'] =  auth()
                ->user()->nombre ?? "N/A";

            // dd(['datosCurso' => $datosCurso]);

            // Carga la vista del PDF con los datos
            $pdf = Pdf::loadView('pdf.curso', ['data' => $datosCurso]);

            // Descarga el PDF
            return $pdf->download('informacion_curso_' . ($curso->nombre ?? 'NC') . '.pdf');

            // ! Error
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'infCurso' => $curso,
                'infCursoTitulo' => 'Detalle del curso ' . $curso->nombre,
                'error_pdf', 'Ocurrió un error al generar el PDF.' . $e->getMessage()
            ]);
        }
    }

    //SECTION - Privadas ----------------


    // ! - Error de registro
    private function catchErrorRegistro(Request $request, $mensaje)
    {
        return redirect()->back()
            ->withInput($request->only(
                'categoria_id',
                'informacion',
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


 // Log del error
            // Log::error('Error al generar el PDF: ' . $e->getMessage());
