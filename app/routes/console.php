<?php

use App\Http\Controllers\consoleController;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Mostrar una cita inspiradora');


//SECTION -  Comandos artisan extras

// * -> php artisan insert-data-primary

// Insertar datos primarios
Artisan::command('insert-data-primary', function () {
    try {

        $consoleController = new consoleController();
        $consoleController->generarDatosPrimariosGlobales();

        $this->info('Éxito, los datos se generaron correctamente.');

        //! - Error
    } catch (Exception $e) {
        $this->error('Ocurrió un error: ' . $e->getMessage());
    }
})->describe('Inserta los datos de las tablas padre.');

// * -> php artisan insert-user-random

// Insertar 10 usuarios aleatorios
Artisan::command('insert-user-random', function () {
    try {

        $consoleController = new consoleController();
        $consoleController->generarUsuariosAleatorios();

        $this->info('Éxito, los usuarios se generaron correctamente.');

        //! - Error
    } catch (Exception $e) {
        $this->error('Ocurrió un error: ' . $e->getMessage());
    }
})->describe('Inserta 10 usuarios aleatorios a la tabla user.');

// * -> php artisan insert-cursos-random

// Insertar 50 cursos aleatorios
Artisan::command('insert-cursos-random', function () {
    try {

        $consoleController = new consoleController();
        $consoleController->generarCursosAleatorios();

        $this->info('Éxito, los cursos se generaron correctamente.');

        //! - Error
    } catch (Exception $e) {
        $this->error('Ocurrió un error: ' . $e->getMessage());
    }
})->describe('Inserta 50 usuarios aleatorios a la tabla cursos.');


// * php artisan clear-env-app
Artisan::command('clear-env-app', function () {
    try {

        // Ejecutamos composer dump-autoload
        exec('composer dump-autoload');

        // Limpiamos
        $this->call('cache:clear');
        $this->call('config:clear');
        $this->call('view:clear');
        $this->info('Caché limpiada con éxito.');

        // ! Error
    } catch (\Throwable $th) {
        $this->error('No se limpio el env correctamente, ' . $th->getMessage());
    }
})->purpose('Limpiar la caché del .env de la aplicación');

// * php artisan clear-cache-app
Artisan::command('clear-cache-app', function () {
    try {

        // Limpiamos
        $this->call('clear-compiled');
        $this->call('cache:clear');
        $this->call('config:cache');
        $this->call('config:clear');
        $this->call('route:clear');
        $this->call('route:cache');
        $this->call('view:clear');
        $this->info('Caché limpiada con éxito.');

        // ! Error
    } catch (\Throwable $th) {
        $this->error('No se limpio la app correctamente, ' . $th->getMessage());
    }
})->purpose('Limpiar la caché de la aplicación');

// * php artisan optimize-app
Artisan::command('optimize-app', function () {
    $this->call('clear-compiled');
    $this->call('optimize:clear');
    $this->call('config:cache');
    $this->call('route:cache');
    $this->info('Optimización completada.');
})->purpose('Optimizar la aplicación para un mejor rendimiento');
