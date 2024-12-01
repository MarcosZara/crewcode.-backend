<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Crear 10 usuarios y 3 proyectos para cada usuario
        \App\Models\User::factory(10)
            ->has(\App\Models\Project::factory(10), 'projects') // Relación definida en el modelo
            ->create();
    }
}
