<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = \App\Models\User::class;

    public function definition()
    {
        $username = $this->faker->unique()->userName;
        return [


            'username' => $username,
            'password' => bcrypt('password'),
            'level' => $this->faker->randomElement(['Principiante', 'Intermedio', 'Avanzado', 'Experto']),

            'bio' => <<<BIO
            - 👋 Hola, soy @{$username}
            - 👀 Estoy interesado en {$this->faker->sentence()}
            - 🌱 Actualmente estoy aprendiendo {$this->faker->sentence()}
            - 💞️ Me gustaría colaborar con {$this->faker->sentence()}
            - 📫 Como contactarme {$this->faker->sentence()}
            - ⚡ Dato curioso {$this->faker->sentence()}
            BIO,
            'interests' => implode(', ', $this->faker->randomElements([
                'Juegos', 'Tiendas', 'Entretenimiento', 'Portfolio', 'Social', 'Negocios'
            ], $this->faker->numberBetween(1, 3))),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
