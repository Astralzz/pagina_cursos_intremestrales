<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Rol_usuario;
use Illuminate\Http\Request;

class rolUsuarioController extends Controller
{
    //Lista
    public static function lista()
    {
        // Lista de las regiones
        return Rol_usuario::orderBy('nombre', 'asc')->get();
    }
}
