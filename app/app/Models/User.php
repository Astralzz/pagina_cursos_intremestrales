<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//TODO - Usuario
class User extends Model
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
        return $this->belongsTo(RoleUsuario::class, 'rol_id');
    }

    // Tiene ....

    public function estudios()
    {
        return $this->hasOne(EstudiosUsuario::class, 'user_id');
    }

    public function reconocimientos()
    {
        return $this->hasOne(ReconocimientosUsuario::class, 'user_id');
    }

    public function cursos()
    {
        return $this->hasMany(Curso::class, 'user_id');
    }
}
