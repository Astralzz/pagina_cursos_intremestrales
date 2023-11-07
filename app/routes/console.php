<?php

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

// Insertar datos primarios
Artisan::command('insert-data-primary', function () {
    try {

        $this->info('Datos primarios insertados en las tablas padre.');
    } catch (Exception $e) {
        $this->error('Ocurrió un error: ' . $e->getMessage());
    }
})->describe('Inserta los datos de las tablas padre.');
