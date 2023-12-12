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
}
