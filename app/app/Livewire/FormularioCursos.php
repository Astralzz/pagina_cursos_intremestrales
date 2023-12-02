<?php

namespace App\Livewire;

use App\Http\Controllers\categoriaCursoController;
use App\Models\Curso;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FormularioCursos extends Component
{

    // * Elementos
    public $user_id;
    public $categoria_id;
    public $nombre;
    public $informacion;
    public $tipo;
    public $nombre_instructor;
    public $sede;
    public $institucion;
    public $fecha_inicio;
    public $fecha_final;

    // * usuario
    public $usuario;

    // * Categorias
    public $categorias_cursos;

    // * Lista de variables
    public $variables = [
        'user_id', 'categoria_id', 'nombre', 'informacion',
        'tipo', 'nombre_instructor', 'sede',
        'fecha_inicio', 'fecha_final',
    ];

    protected $rules = [];
    protected $messages = [];

    //TODO - Constructor
    public function __construct()
    {
        // Iniciamos
        $this->usuario = Auth::user();

        // Categorias
        $this->categorias_cursos = categoriaCursoController::lista();

        // Asignamos datos
        $this->user_id = $this->usuario->id;
    }

    // * Validaciones
    protected function rules()
    {
        return  [
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
    }

    // * Respuestas de rules
    protected function messages()
    {
        return  [
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
            'fecha_final.required' => 'El campo fecha de final es requerido.',
            'fecha_final.date' => 'El campo fecha final debe ser una fecha válida.',
            'fecha_final.after_or_equal' => 'La fecha final debe ser igual o posterior a la fecha de inicio.',
        ];
    }

    // * Constructor de validacion
    protected function applyValidation()
    {
        $this->rules = $this->rules();
        $this->messages = $this->messages();

        $this->validate();
    }

    // * Obtener datos validados
    protected function getData()
    {
        return $this->validate();
    }

    // * Validar e tiempo real
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    // * Acción formulario
    public function guardarCurso()
    {

        // Validamos
        $this->applyValidation();

        // Obtenemos los datos validados
        $validatedData = $this->getData();

        // Creamos el curso
        Curso::create($validatedData);

        // Lanzamos evento
        $this->dispatch('alert-swall', [
            'titulo' => 'Exito',
            'mensaje' => 'El curso se creo correctamente',
            'tipo' => 'success'
        ]);

        // Limpiamos
        $this->reset($this->variables);
    }

    public function render()
    {
        return view('livewire.formulario-cursos');
    }
}
