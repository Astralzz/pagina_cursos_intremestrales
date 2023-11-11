<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Estudios_usuario;
use App\Models\Rol_usuario;
use App\Models\User;
use Dotenv\Exception\ValidationException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

//TODO - Controlador de usuario
class usuarioController extends Controller
{
    // * Renta
    protected $usuario;
    protected $estudio;

    // * Validaciones
    private $validaciones = [
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
        'licenciatura' => 'nullable|in:on,off',
        'maestria' => 'nullable|in:on,off',
        'doctorado' => 'nullable|in:on,off',
        'postgrado' => 'nullable|in:on,off',
        'admin_key' => 'nullable|numeric|digits:12',
    ];

    // * Respuestas de validaciones
    private $respuestas = [
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
        'licenciatura.in' => 'El campo Licenciatura debe ser un valor on.',
        'maestria.in' => 'El campo Maestría debe ser un valor on.',
        'doctorado.in' => 'El campo Doctorado debe ser un valor on.',
        'postgrado.in' => 'El campo Postgrado debe ser un valor on.',
        'admin_key.numeric' => 'El campo clave administrador debe ser numérica.',
        'admin_key.digits' => 'El campo clave administrador debe tener 12 dígitos.',
    ];

    //Constructor
    public function __construct(User $usuario, Estudios_usuario $estudio)
    {
        $this->usuario = $usuario;
        $this->estudio = $estudio;
    }

    // * Login
    public function login(Request $request)
    {
        try {
            // Validamos datos
            $request->validate([
                'email' => 'required|email|string|min:5|max:120',
                'password' => 'required|string|min:8|max:16',
            ], [
                'email.required' => 'El campo email es requerido.',
                'email.email' => 'El campo email debe ser una dirección de correo válida.',
                'email.string' => 'El campo email debe ser una cadena de texto.',
                'email.min' => 'El campo email debe tener al menos 5 caracteres.',
                'email.max' => 'El campo email debe tener como máximo 120 caracteres.',
                'password.required' => 'El campo contraseña es requerido.',
                'password.string' => 'El campo contraseña debe ser una cadena de texto.',
                'password.min' => 'El campo contraseña debe tener al menos 8 caracteres.',
                'password.max' => 'El campo contraseña debe tener como máximo 16 caracteres.',
            ]);

            //credenciales
            $credentials = [
                'email' => $request->input('email'),
                'password' => $request->input('password'),
            ];

            // ? Verificamos
            if (auth()->attempt($credentials)) {
                // Autenticación exitosa
                auth()->user();

                // * Exito
                return redirect()->back();
            }

            // ! Datos incorrectos
            return $this->catchErrorLogin($request, 'Datos incorrectos.');

            // ! - Errores
        } catch (ValidationException $e) {
            return $this->catchErrorLogin($request, 'Error de validación, ' . $e->getMessage());
        } catch (QueryException $e) {
            return $this->catchErrorLogin($request, 'Error de query, ' . $e->getMessage());
        } catch (\Exception $e) {
            return $this->catchErrorLogin($request, 'Error desconocido, ' . $e->getMessage());
        }
    }

    // * Cerra sesión
    public function salir()
    {
        // Cerrar la sesión
        auth()->logout();

        // Volvemos a /
        return redirect('/');
    }

    // * Registro
    public function registro(Request $request)
    {

        try {

            // Validamos
            $request->validate($this->validaciones, $this->respuestas);

            // Comprobamos clave de administrador
            $this->comprobarAdminKey($request->input('rol_id'), $request->input('admin_key'));

            // ? Contraseñas diferentes
            if ($request->input('password') !== $request->input('password2')) {
                return $this->catchErrorRegistro($request, 'Las contraseñas no coinciden.');
            }

            // Creamos usuario
            $nuevoUsuario = new User([
                'nombre' => $request->input('nombre'),
                'rol_id' => $request->input('rol_id'),
                'rfc' => $request->input('rfc'),
                'telefono' => $request->input('telefono'),
                'email' => $request->input('email'),
                'clave_propuesta' => $request->input('clave_propuesta'),
                'tipo_puesto' => $request->input('tipo_puesto'),
                'nivel_puesto' => $request->input('nivel_puesto'),
                'institucion' => $request->input('institucion'),
                'departamento' => $request->input('departamento'),
                'nombre_jefe' => $request->input('nombre_jefe'),
                'horario' => $request->input('horario'),
                'domicilio' => $request->input('domicilio'),
                'password' => Hash::make($request->input('password')),
            ]);

            // Guardamos
            $nuevoUsuario->save();

            // Creamos estudio
            $nuevoEstudio = new Estudios_usuario([
                'user_id' => $nuevoUsuario->id,
                'licenciatura' => $request->input('licenciatura') === 'on',
                'maestria' => $request->input('maestria') === 'on',
                'doctorado' => $request->input('doctorado') === 'on',
                'postgrado' => $request->input('postgrado') === 'on',
            ]);

            // Guardar el estudio en la base de datos
            $nuevoEstudio->save();

            // * Éxito
            return redirect()->back()
                ->with('exito_formulario', 'El usuario se creo correctamente, ya puedes iniciar sesión');

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
            // Obtenemos el usuario existente
            $usuario = User::find(auth()->user()->id);

            // ? No existe
            if (!$usuario) {
                return $this->catchErrorRegistro($request, 'No se encontró el usuario.');
            }

            // Obtenemos el estudio asociado al usuario
            $estudio = Estudios_usuario::where('user_id', $usuario->id)->first();

            // ? No existe
            if (!$estudio) {
                return $this->catchErrorRegistro($request, 'No se encontró el estudio.');
            }

            // Validar datos
            $request->validate(
                array_diff_key(
                    $this->validaciones,
                    [
                        'rol_id' => '',
                        'email' => '',
                        'password2' => '',
                        'admin_key' => '',
                    ]
                ),
                array_diff_key(
                    $this->respuestas,
                    [
                        'rol_id.required' => '',
                        'rol_id.numeric' => '',
                        'email.required' => '',
                        'email.unique' => '',
                        'email.email' => '',
                        'email.string' => '',
                        'email.min' => '',
                        'email.max' => '',
                        'password2.required' => '',
                        'password2.string' => '',
                        'password2.min' => '',
                        'password2.max' => '',
                        'admin_key.numeric' => '',
                        'admin_key.digits' => '',
                    ]
                )
            );

            // Validamos la contraseña
            if (!Hash::check($request->input('password'), $usuario->password)) {
                return $this->catchErrorRegistro($request, 'La contraseña es incorrecta');
            }

            // Actualizar datos del usuario
            $usuario->update([
                'nombre' => $request->input('nombre'),
                'rfc' => $request->input('rfc'),
                'telefono' => $request->input('telefono'),
                'clave_propuesta' => $request->input('clave_propuesta'),
                'tipo_puesto' => $request->input('tipo_puesto'),
                'nivel_puesto' => $request->input('nivel_puesto'),
                'institucion' => $request->input('institucion'),
                'departamento' => $request->input('departamento'),
                'nombre_jefe' => $request->input('nombre_jefe'),
                'horario' => $request->input('horario'),
                'domicilio' => $request->input('domicilio'),
            ]);

            // Actualizar datos del estudio
            $estudio->update([
                'licenciatura' => $request->input('licenciatura') === 'on',
                'maestria' => $request->input('maestria') === 'on',
                'doctorado' => $request->input('doctorado') === 'on',
                'postgrado' => $request->input('postgrado') === 'on',
            ]);

            // Éxito
            return redirect()->back()->with('exito_formulario', 'Los datos se actualizaron correctamente.');
        } catch (ValidationException $e) {
            return $this->catchErrorRegistro($request, 'Error de validación, ' . $e->getMessage());
        } catch (QueryException $e) {
            return $this->catchErrorRegistro($request, 'Error de query, ' . $e->getMessage());
        } catch (\Exception $e) {
            return $this->catchErrorRegistro($request, 'Error desconocido, ' . $e->getMessage());
        }
    }

    //SECTION - Privadas ----------------

    // * Comprobar clave admin
    private  function comprobarAdminKey(string $rol_id, ?string $key)
    {
        // Obtenemos rol
        $rol = Rol_usuario::find($rol_id);

        // ? No existe
        if (!$rol) {
            throw new \Exception('No se encontró el rol de usuario.');
        }

        // ? Rol de administrador
        if ($rol->is_admin) {

            // ? No existe
            if (!$key) {
                throw new \Exception('Para ser admin tienes que poner la clave de administrador');
            }

            // ? No existe
            if (!env('KEY_ADMIN')) {
                throw new \Exception('No se encontró la key del administrador, actualiza .env .');
            }

            // ? Diferentes
            if ($key !== env('KEY_ADMIN')) {
                throw new \Exception('La clave del administrador es incorrecta');
            }
        }
    }

    // ! - Error de login
    private function catchErrorLogin(Request $request, $mensaje)
    {
        return redirect()->back()
            ->withInput($request->only(
                'email',
            ))
            ->with('error_login', $mensaje);
    }

    // ! - Error de registro
    private function catchErrorRegistro(Request $request, $mensaje)
    {
        return redirect()->back()
            ->withInput($request->only(
                'nombre',
                'rol_id',
                'rfc',
                'telefono',
                'email',
                'clave_propuesta',
                'tipo_puesto',
                'nivel_puesto',
                'institucion',
                'departamento',
                'nombre_jefe',
                'horario',
                'domicilio',
                'licenciatura',
                'maestria',
                'doctorado',
                'postgrado'
            ))
            ->with('error_formulario', $mensaje);
    }
}
