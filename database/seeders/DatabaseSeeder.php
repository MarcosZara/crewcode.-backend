<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {

        \App\Models\User::factory()->admin()->create();
        \App\Models\User::factory(10)
            ->has(\App\Models\Project::factory(10), 'projects')
            ->create();
    }
}
