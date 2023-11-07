<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//TODO - Categorias de los cursos
class Categoria_curso extends Model
{

    // Tabla
    protected $table = 'categorias_cursos';

    // Usar datos de prueba
    use HasFactory;

    // Mostrar
    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    // Ocultos
    protected $hidden = [
        'updated_at',
        'created_at',
    ];


    // Tiene
    public function cursos()
    {
        return $this->hasMany(Curso::class, 'categoria_id');
    }
}
