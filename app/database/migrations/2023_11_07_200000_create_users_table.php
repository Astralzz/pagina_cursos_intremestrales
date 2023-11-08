<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


//TODO - Tabla de usuarios
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rol_id');
            $table->string('nombre');
            $table->string('rfc')->nullable();
            $table->string('telefono');
            $table->string('email')->unique();
            $table->enum('tipo_puesto', ['BASE', 'INTERNO'])->default('BASE');
            $table->enum('nivel_puesto', ['FUNCIONARIO', 'ENLACE', 'OPERATIVO'])->default('FUNCIONARIO');
            $table->string('institucion');
            $table->string('departamento')->nullable();
            $table->string('clave_propuesta')->nullable();
            $table->string('nombre_jefe')->nullable();
            $table->text('domicilio')->nullable();
            $table->string('horario')->nullable();
            $table->string('password');
            $table->timestamps();

            // Llave foránea
            $table->foreign('rol_id')
                ->references('id')
                ->on('roles_usuarios')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
