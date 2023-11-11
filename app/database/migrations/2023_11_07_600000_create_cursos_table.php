<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//TODO - Cursos
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('categoria_id');
            $table->string('nombre')->unique();
            $table->enum('tipo', ['PRESENCIAL', 'VIRTUAL'])->default('PRESENCIAL');
            $table->string('nombre_instructor');
            $table->string('sede')->nullable();
            $table->date('fecha_inicio');
            $table->date('fecha_final')->nullable();
            $table->boolean('status')->default(false);
            $table->timestamps();

            // Llaves foráneas
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('categoria_id')
                ->references('id')
                ->on('categorias_cursos')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
