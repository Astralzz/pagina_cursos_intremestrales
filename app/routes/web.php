<?php

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
    return view('index');
})->name('index');

// * 404
Route::fallback(function () {
    return view('index');
})->name(("404"));


//SECTION - Usuarios
Route::group(['prefix' => 'usuario'], function () {
    // //Vista de l login de los sub admin
    // Route::get('login', function () {
    //     //Retornamos la tabla y la variable arrayNoticias
    //     return view('pages.admin.login');
    // })->name('vista.login.administradores');
    //Login sub admin

    //STUB - Login
    Route::post(
        'acceder',
        [usuarioController::class, 'login']
    )->name('usuario.login');

    //STUB - Registro
    Route::post(
        'registrar',
        [usuarioController::class, 'registro']
    )->name('usuario.registro');

    // //Cerra sesión
    // Route::get(
    //     'cerrar',
    //     [
    //         administradorController::class,
    //         'cerrar'
    //     ]
    // )->name('administrador.salir');
});
