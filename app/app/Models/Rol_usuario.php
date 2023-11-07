<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//TODO - Rol del usuario
class Rol_usuario extends Model
{
    // Tabla
    protected $table = 'roles_usuarios';

    // Usar datos de prueba
    use HasFactory;

    // Mostrar
    protected $fillable = [
        'nombre',
        'is_admin',
    ];

    // Ocultos
    protected $hidden = [
        'updated_at',
        'created_at',
    ];

    // Contiene
    public function usuario()
    {
        return $this->hasMany(User::class, 'rol_id');
    }
}
