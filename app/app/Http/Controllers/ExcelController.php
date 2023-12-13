<?php

namespace App\Http\Controllers;

use App\Exports\CursosExport;
use App\Http\Controllers\Controller;
use App\Models\Curso;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{


    // * Curso
    protected $curso;

    protected $dataCursos = [
        [
            'Nombre del Curso',
            'Categoría',
            'Información',
            'Capacidad',
            'Tipo',
            'Nombre del Instructor',
            'Sede',
            'Fecha de Inicio',
            'Fecha de Finalización',
            'Estado',
        ]
    ];

    protected $dataAlumnosCurso = [
        [
            'Nombre del Alumno',
            'RFC',
            'Teléfono',
            'Email',
            'Tipo de Puesto',
            'Nivel de Puesto',
            'Institución',
            'Departamento',
            'Clave Propuesta',
            'Nombre del Jefe',
            'Domicilio',
            'Horario'
        ]
    ];

    //Constructor
    public function __construct(Curso $curso)
    {
        $this->curso = $curso;
    }

    public function exportPublicos()
    {
        try {
            // Obtenemos aceptados
            $cursos = $this->curso
                ->with([
                    'usuario:id,nombre',
                    'categoria:id,nombre'
                ])
                ->where('status', 'ACEPTADO')
                ->get();


            // ? Esta vació
            if ($cursos->isEmpty()) {
                return back()->with('error_action_tabla', 'No hay cursos para exportar.');
            };

            // Recorremos
            foreach ($cursos as $curso) {
                $this->dataCursos[] = [
                    $curso->nombre,
                    $curso->categoria->nombre,
                    $curso->informacion,
                    $curso->capacidad,
                    $curso->tipo,
                    $curso->nombre_instructor,
                    $curso->sede,
                    $curso->fecha_inicio,
                    $curso->fecha_final,
                    $curso->status,
                ];
            }

            // Fecha y hora actual formateada
            $fechaHora = Carbon::now()->format('Ymd_His') ?? 'N_A';

            // Nombre del archivo
            $nameFile =  'lista_cursos_publicos_' . $fechaHora . '.xlsx';

            // Creamos un archivo Excel
            return response()->download(
                Excel::download(new CursosExport($this->dataCursos), $nameFile)->getFile(),
                $nameFile,
                ['Content-Type' => 'application/vnd.ms-excel']
            );
        } catch (\Exception $e) {
            return back()->with('error_action_tabla', 'No se pudo exportar el Excel correctamente, ' . $e->getMessage());
        }
    }

    public function exportAlumnosCurso($idCurso)
    {
        try {
            // Obtener el curso por su ID
            $curso = Curso::find($idCurso);

            if (!$curso) {
                return back()->with('error_action_tabla', 'Curso no encontrado.');
            }

            // Obtener la lista de usuarios inscritos en el curso
            $alumnosInscritos = $curso->usuariosInscritos;

            // Verificar si hay alumnos inscritos
            if ($alumnosInscritos->isEmpty()) {
                return back()->with('error_action_tabla', 'No hay alumnos inscritos en este curso.');
            }

            // Recorrer la lista de alumnos inscritos y agregar sus datos al array
            foreach ($alumnosInscritos as $alumno) {
                $this->dataAlumnosCurso[] = [
                    $alumno->nombre ?? "N/A",
                    $alumno->rfc ?? "N/A",
                    $alumno->telefono ?? "N/A",
                    $alumno->email ?? "N/A",
                    $alumno->tipo_puesto ?? "N/A",
                    $alumno->nivel_puesto ?? "N/A",
                    $alumno->institucion ?? "N/A",
                    $alumno->departamento ?? "N/A",
                    $alumno->clave_propuesta ?? "N/A",
                    $alumno->nombre_jefe ?? "N/A",
                    $alumno->domicilio ?? "N/A",
                    $alumno->horario ?? "N/A",
                ];
            }

            // Fecha y hora actual formateada
            $fechaHora = Carbon::now()->format('Ymd_His') ?? 'N_A';

            // Nombre del archivo
            $nameFile = 'alumnos_curso_' . $curso->nombre . $fechaHora . '.xlsx';

            // Creamos un archivo Excel
            return response()->download(
                Excel::download(new CursosExport($this->dataAlumnosCurso), $nameFile)->getFile(),
                $nameFile,
                ['Content-Type' => 'application/vnd.ms-excel']
            );
        } catch (\Exception $e) {
            return back()->with('error_action_tabla', 'No se pudo exportar el Excel correctamente, ' . $e->getMessage());
        }
    }
}
