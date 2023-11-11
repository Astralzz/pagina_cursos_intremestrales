<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Categoria_curso;

class categoriaCursoController extends Controller
{
    //Lista
    public static function lista()
    {
        // Lista de las regiones
        return Categoria_curso::orderBy('nombre', 'asc')->get();
    }
}
