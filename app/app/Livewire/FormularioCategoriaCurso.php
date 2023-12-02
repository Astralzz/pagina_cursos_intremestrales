<?php

namespace App\Livewire;

use App\Http\Controllers\categoriaCursoController;
use App\Models\Categoria_curso;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

//TODO - Formulario categoria curso
class FormularioCategoriaCurso extends Component
{

    // * Elementos
    public $nombre;
    public $descripcion;

    // * usuario
    public $usuario;

    // * Categorias
    public $categorias_cursos;

    // * Lista de variables
    public $variables = [
        'nombre', 'descripcion',
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
    }

    // * Validaciones
    protected function rules()
    {
        return  [
            'nombre' => 'required|unique:categorias_cursos,nombre|string|min:2|max:240',
            'descripcion' => 'nullable|string|min:5',
        ];
    }

    // * Respuestas de rules
    protected function messages()
    {
        return  [
            'nombre.required' => 'El campo es requerido.',
            'nombre.unique' => 'El nombre proporcionado ya esta en existencia.',
            'nombre.string' => 'El campo nombre debe ser una cadena de texto.',
            'nombre.min' => 'El campo nombre debe tener al menos 5 caracteres.',
            'nombre.max' => 'El campo nombre debe tener como máximo 240 caracteres.',
            'descripcion.string' => 'El campo descripcion debe ser una cadena de texto.',
            'descripcion.min' => 'El campo descripcion debe tener al menos 5 caracteres.',
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
    public function guardarCategoria()
    {

        // Validamos
        $this->applyValidation();

        // Obtenemos los datos validados
        $validatedData = $this->getData();

        // Creamos el curso
        Categoria_curso::create($validatedData);

        // Lanzamos evento
        $this->dispatch('alert-swall', [
            'titulo' => 'Exito',
            'mensaje' => 'La categoria se creo correctamente',
            'tipo' => 'success'
        ]);

        // Limpiamos
        $this->reset($this->variables);
    }

    public function render()
    {
        return view('livewire.formulario-categoria-curso');
    }
}
