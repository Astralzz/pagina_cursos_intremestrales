<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // * Valor para enum
        Validator::extend('enum_value', function ($attribute, $value, $parameters, $validator) {
            // Valores permitidos para el campo enum
            $allowedValues = $parameters;

            // Verificamos si el valor está en la lista de valores permitidos
            return in_array($value, $allowedValues);
        });

        // * Mensajes de error personalizados
        Validator::replacer('enum_value', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':values', implode(', ', $parameters), $message);
        });
    }
}
