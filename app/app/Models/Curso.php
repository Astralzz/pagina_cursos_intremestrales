<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//TODO - Cursos
class Curso extends Model
{

    // Tabla
    protected $table = 'cursos';

    // Usar datos de prueba
    use HasFactory;

    // Mostrar
    protected $fillable = [
        'user_id',
        'categoria_id',
        'nombre',
        'informacion',
        'tipo',
        'nombre_instructor',
        'sede',
        'fecha_inicio',
        'fecha_final',
        'status'
    ];

    // Ocultos
    protected $hidden = [
        'updated_at',
        'created_at',
    ];

    // Pertenece a ....

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function categoria()
    {
        return $this->belongsTo(CategoriaCurso::class, 'categoria_id');
    }
}
