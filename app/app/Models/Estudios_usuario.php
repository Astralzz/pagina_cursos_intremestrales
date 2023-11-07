<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//TODO - Estudios usuario
class Estudios_usuario extends Model
{

    // Tabla
    protected $table = 'estudios_usuarios';

    // Usar datos de prueba
    use HasFactory;

    // Mostrar
    protected $fillable = [
        'user_id',
        'licenciatura',
        'maestria',
        'doctorado',
        'postgrado',
    ];

    // Ocultos
    protected $hidden = [
        'updated_at',
        'created_at',
    ];

    // Pertenece a
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
