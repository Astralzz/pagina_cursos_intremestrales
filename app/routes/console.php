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
})->purpose('Display an inspiring quote');


//SECTION -  Comandos artisan extras

//* -> php artisan insert-data-primary

// Insertar datos primarios
Artisan::command('insert-data-primary', function () {
    try {

        $consoleController = new consoleController();
        $consoleController->generarDatosPrimariosGlobales();

        $this->info('Éxito, los datos se insertaron correctamente.');

        //! - Error
    } catch (Exception $e) {
        $this->error('Ocurrió un error: ' . $e->getMessage());
    }
})->describe('Inserta los datos de las tablas padre.');
