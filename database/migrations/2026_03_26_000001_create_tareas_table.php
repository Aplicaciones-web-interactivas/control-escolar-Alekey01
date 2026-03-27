<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tareas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 255);
            $table->text('descripcion')->nullable();
            $table->foreignId('maestro_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('alumno_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('materia_id')->constrained('materias')->cascadeOnDelete();
            $table->date('fecha_entrega')->nullable();
            $table->enum('estado', ['pendiente', 'entregada', 'calificada'])->default('pendiente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tareas');
    }
};
