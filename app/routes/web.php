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
    return view('sections.inicio');
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

    //STUB - Listas
    Route::group(['prefix' => 'lista'], function () {

        // Completa
        Route::get('{id}', [cursoController::class, 'listaPorId'])->name('curso.lista.id');

        // Por status
        Route::get('status/{id}/{status}', [cursoController::class, 'listaPorStatus'])->name('curso.lista.status');

        // Pos titulo
        Route::post('titulo/{id}', [cursoController::class, 'listaPorTitulo'])->name('curso.lista.titulo');

        // Publica
        Route::group(['prefix' => 'publica'], function () {

            // Completa
            Route::get('total', [cursoController::class, 'listaPublica'])->name('curso.lista.publica');

            // Pos titulo
            Route::post('titulo', [cursoController::class, 'listaPublicaPorTitulo'])->name('curso.lista.publica.titulo');
        });
    });
});
