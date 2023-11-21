<?php

namespace App\Livewire;

use App\Http\Controllers\rolUsuarioController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

//TODO - Formulario usuario
class FormularioUsuario extends Component
{


    // * Elementos
    public $nombre;
    public $email;
    public $clave_propuesta;
    public $tipo_puesto;
    public $nivel_puesto;
    public $rol_id;
    public $telefono;
    public $rfc;
    public $institucion;
    public $departamento;
    public $nombre_jefe;
    public $horario;
    public $licenciatura;
    public $maestria;
    public $doctorado;
    public $postgrado;
    public $domicilio;
    public $password;
    public $password2;
    public $admin_key;

    // * usuario
    public $usuario;


    // * Mostrar contraseña
    public $mostrar_pass = false;

    // * Roles usuarios
    public $roles_usuarios;
    public $estudios_usuario = [
        'licenciatura', 'maestria',
        'doctorado', 'postgrado'
    ];

    // * Lista de variables
    public $variables = [
        'nombre', 'rol_id', 'rfc', 'telefono',
        'email', 'clave_propuesta', 'tipo_puesto',
        'nivel_puesto', 'institucion', 'departamento',
        'nombre_jefe', 'horario', 'licenciatura', 'maestria',
        'doctorado', 'postgrado', 'domicilio', 'password',
        'password2', 'admin_key',
    ];

    protected $rules = [];
    protected $messages = [];

    public function __construct()
    {
        $this->roles_usuarios = rolUsuarioController::lista();
        $this->usuario = Auth::user();

        foreach ($this->estudios_usuario as $variable) {
            $this->$variable = $this->usuario && $this->usuario->estudios->$variable ?? false;
        }

        // * Constructor de clase base
        // parent::__construct();
    }

    // * Validaciones
    protected function rules()
    {
        return  [
            'nombre' => 'required|string|min:5|max:240',
            'password' => 'required|string|min:8|max:16',
            'password2' => 'required|string|min:8|max:16',
            'rol_id' => 'required|numeric',
            'rfc' => 'nullable|string|min:12|max:12',
            'telefono' => 'required|numeric|digits:10',
            'email' => 'required|unique:users,email|email|string|min:5|max:120',
            'clave_propuesta' => 'nullable|numeric|digits:8',
            'tipo_puesto' => 'nullable|in:BASE,INTERNO',
            'nivel_puesto' => 'nullable|in:FUNCIONARIO,ENLACE,OPERATIVO',
            'institucion' => 'required|string|min:5|max:120',
            'departamento' => 'nullable|string|min:5|max:120',
            'nombre_jefe' => 'nullable|string|min:5|max:120',
            'horario' => 'nullable|string|min:5|max:120',
            'domicilio' => 'nullable|string|min:5',
            'licenciatura' => 'nullable|boolean',
            'maestria' => 'nullable|boolean',
            'doctorado' => 'nullable|boolean',
            'postgrado' => 'nullable|boolean',
            'admin_key' => 'nullable|numeric|digits:12',
        ];
    }

    // * Respuestas de rules
    protected function messages()
    {
        return  [
            'nombre.required' => 'El campo nombre es requerido.',
            'nombre.string' => 'El campo nombre debe ser una cadena de texto.',
            'nombre.min' => 'El campo nombre debe tener al menos 5 caracteres.',
            'nombre.max' => 'El campo nombre debe tener como máximo 240 caracteres.',
            'password.required' => 'El campo contraseña es requerido.',
            'password.string' => 'El campo contraseña debe ser una cadena de texto.',
            'password.min' => 'El campo contraseña debe tener al menos 8 caracteres.',
            'password.max' => 'El campo contraseña debe tener como máximo 16 caracteres.',
            'password2.required' => 'El campo de la segunda contraseña es requerido.',
            'password2.string' => 'El campo de la segunda contraseña debe ser una cadena de texto.',
            'password2.min' => 'El campo de la segunda contraseña debe tener al menos 8 caracteres.',
            'password2.max' => 'El campo de la segunda contraseña debe tener como máximo 16 caracteres.',
            'password2.same' => 'Las contraseñas deben ser iguales.',
            'rol_id.required' => 'El campo rol es requerido.',
            'rol_id.numeric' => 'El campo rol debe ser un número.',
            'rfc.string' => 'El campo RFC debe ser una cadena de texto.',
            'rfc.min' => 'El campo RFC debe tener 12 caracteres.',
            'rfc.max' => 'El campo RFC debe tener 12 caracteres.',
            'telefono.required' => 'El campo teléfono es requerido.',
            'telefono.numeric' => 'El campo teléfono debe ser un número.',
            'telefono.digits' => 'El campo teléfono debe tener 10 dígitos.',
            'email.required' => 'El campo email es requerido.',
            'email.unique' => 'El email proporcionado ya se encentra registrado.',
            'email.email' => 'El campo email debe ser una dirección de correo válida.',
            'email.string' => 'El campo email debe ser una cadena de texto.',
            'email.min' => 'El campo email debe tener al menos 5 caracteres.',
            'email.max' => 'El campo email debe tener como máximo 120 caracteres.',
            'clave_propuesta.numeric' => 'El campo clave propuesta debe ser un número.',
            'clave_propuesta.digits' => 'El campo clave propuesta debe tener 8 dígitos.',
            'tipo_puesto.in' => 'El campo tipo de puesto debe ser "BASE" o "INTERNO".',
            'nivel_puesto.in' => 'El campo nivel de puesto debe ser "FUNCIONARIO", "ENLACE" o "OPERATIVO".',
            'institucion.required' => 'El campo institución es requerido.',
            'institucion.string' => 'El campo institución debe ser una cadena de texto.',
            'institucion.min' => 'El campo institución debe tener al menos 5 caracteres.',
            'institucion.max' => 'El campo institución debe tener como máximo 120 caracteres.',
            'departamento.string' => 'El campo departamento debe ser una cadena de texto.',
            'departamento.min' => 'El campo departamento debe tener al menos 5 caracteres.',
            'departamento.max' => 'El campo departamento debe tener como máximo 120 caracteres.',
            'nombre_jefe.string' => 'El campo jefe debe ser una cadena de texto.',
            'nombre_jefe.min' => 'El campo jefe debe tener al menos 5 caracteres.',
            'nombre_jefe.max' => 'El campo jefe debe tener como máximo 120 caracteres.',
            'horario.string' => 'El campo horario debe ser una cadena de texto.',
            'horario.min' => 'El campo horario debe tener al menos 5 caracteres.',
            'horario.max' => 'El campo horario debe tener como máximo 120 caracteres.',
            'domicilio.string' => 'El campo domicilio debe ser una cadena de texto.',
            'domicilio.min' => 'El campo domicilio debe tener al menos 5 caracteres.',
            'licenciatura.boolean' => 'El campo Licenciatura debe ser un valor booleano.',
            'maestria.boolean' => 'El campo Maestría debe ser un valor booleano.',
            'doctorado.boolean' => 'El campo Doctorado debe ser un valor booleano.',
            'postgrado.boolean' => 'El campo Postgrado debe ser un valor booleano.',
            'admin_key.numeric' => 'El campo clave administrador debe ser numérica.',
            'admin_key.digits' => 'El campo clave administrador debe tener 12 dígitos.',
            'admin_key.in' => 'La clave administrador no es válida.',
        ];
    }

    // * Constructor de validacion
    protected function applyValidation()
    {
        $this->rules = $this->rules();
        $this->messages = $this->messages();

        // ? No existe empty es vacía
        if (env('ADMIN_KEY') !== null) {
            $this->addError('admin_key', 'La clave de administrador no está configurada correctamente en el archivo .env.');
            return;
        }

        // Agregar reglas de validación adicionales
        $this->rules['password2'] = 'required|string|min:8|max:16|same:password';
        $this->rules['admin_key'] = 'required|numeric|digits:12|in:' . env('ADMIN_KEY');

        $this->validate();
    }

    // * Validar e tiempo real
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    // * Acción formulario
    public function guardarUsuario()
    {

        // * Validamos
        // $validatedData =  $this->applyValidation();

        // dd($validatedData);

        // Creamos
        // User::create($validatedData);

        // Eventos success
        // $this->emit('postAdded');


        // Lanzamos evento
        $this->dispatch('alert-swall', [
            'titulo' => 'Exito',
            'mensaje' => 'El usuario se creo correctamente',
            'tipo' => 'success'
        ]);


        // Limpiamos
        $this->reset($this->variables);
    }

    // * Vista
    public function render()
    {
        return view('livewire.formulario-usuario');
    }
}
