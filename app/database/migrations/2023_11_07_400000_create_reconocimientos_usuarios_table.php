<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//TODO - Reconocimientos de los usuarios
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reconocimientos_usuarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->boolean('sni')->default(false);
            $table->unsignedTinyInteger('sni_nivel')->default(0);
            $table->boolean('edd')->default(false);
            $table->unsignedTinyInteger('edd_nivel')->default(0);
            $table->boolean('pd')->default(false);
            $table->unsignedTinyInteger('pd_nivel')->default(0);
            $table->timestamps();

            // Llave foránea
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reconocimientos_usuarios');
    }
};
