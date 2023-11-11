<?php

use App\Http\Controllers\cursoController;
use App\Http\Controllers\usuarioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// * Index
Route::get('/', function () {
    return view('sections.section_inicio');
})->name('index');

// * 404
Route::fallback(function () {
    return view('index');
})->name(("404"));


//SECTION - Usuarios
Route::group(['prefix' => 'usuarios'], function () {

    //STUB - Login
    Route::post(
        'acceder',
        [usuarioController::class, 'login']
    )->name('usuario.login');

    //STUB - Salir
    Route::get(
        'salir',
        [usuarioController::class, 'salir']
    )->name('usuario.exit');

    //STUB - Registro
    Route::post(
        'registrar',
        [usuarioController::class, 'registro']
    )->name('usuario.registro');

    //STUB - Editar
    Route::post(
        'editar',
        [usuarioController::class, 'editar']
    )->name('usuario.editar');
});


//SECTION - Cursos
Route::group(['prefix' => 'cursos'], function () {

    //STUB - Registro
    Route::post(
        'registrar',
        [cursoController::class, 'registro']
    )->name('curso.registro');

    //STUB - Editar
    Route::post(
        'editar',
        [cursoController::class, 'editar']
    )->name('curso.editar');
});
