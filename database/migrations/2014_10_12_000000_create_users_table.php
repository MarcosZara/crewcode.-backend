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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 50)->unique();

            $table->string('password', 255);
            $table->string('level', 50)->nullable();
            $table->string('profile_image')->default('https://img.freepik.com/vector-premium/perfil-avatar-hombre-icono-redondo_24640-14044.jpg');
            $table->text('bio')->nullable();
            $table->string('interests')->nullable();
            $table->timestamps();
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
