<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->text('description');
            $table->foreignId('creator_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['Activo', 'Completado', 'Archivado'])->default('Activo');
            $table->string('image_url')->nullable();
            $table->string('theme')->nullable();
            $table->string('technologies')->nullable();
            $table->enum('level', ['Básico', 'Intermedio', 'Avanzado'])->default('Básico');
            $table->text('goal')->nullable();
            $table->string('duration')->nullable();
            $table->unsignedInteger('team_size')->nullable();
            $table->string('repository_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
