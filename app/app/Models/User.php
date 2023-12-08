<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//TODO - Usuario
class User extends Model implements Authenticatable
{

    // Tabla
    protected $table = 'users';

    // Usar datos de prueba
    use HasFactory;

    // Mostrar
    protected $fillable = [
        'rol_id',
        'nombre',
        'rfc',
        'telefono',
        'email',
        'tipo_puesto',
        'nivel_puesto',
        'institucion',
        'departamento',
        'clave_propuesta',
        'nombre_jefe',
        'domicilio',
        'horario',
        'password',
    ];

    // Ocultos
    protected $hidden = [
        'updated_at',
        'created_at',
    ];

    // Pertenece a
    public function rol()
    {
        return $this->belongsTo(Rol_usuario::class, 'rol_id');
    }

    // Tiene ....

    public function estudios()
    {
        return $this->hasOne(Estudios_usuario::class, 'user_id');
    }

    public function cursos()
    {
        return $this->hasMany(Curso::class, 'user_id');
    }

    public function inscripciones()
    {
        return $this->belongsToMany(Curso::class, 'inscripcion_cursos', 'user_id', 'curso_id');
    }


    //SECTION - Autenticación

    // Identificador
    public function getAuthIdentifierName()
    {
        return 'id';
    }

    // Contraseña
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    // Contraseña
    public function getAuthPassword()
    {
        return $this->password;
    }

    // Get token
    public function getRememberToken()
    {
        return $this->remember_token;
    }

    // Set token
    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    // Tabla token
    public function getRememberTokenName()
    {
        return 'remember_token';
    }
}
