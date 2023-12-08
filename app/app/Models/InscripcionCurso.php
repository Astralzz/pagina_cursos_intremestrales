<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InscripcionCurso extends Model
{
    // Tabla
    protected $table = 'inscripcion_cursos';

    // Usar datos de prueba
    use HasFactory;

    // Mostrar
    protected $fillable = [
        'user_id',
        'curso_id',
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

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'curso_id');
    }
}
