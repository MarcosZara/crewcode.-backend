<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    protected $model = \App\Models\Project::class;

    public function definition()
    {
        return [
            'title' => $this->faker->randomElement([
                'Plataforma', 'Sistema', 'App', 'Herramienta', 'Portal', 'Rediseño', 'Blog'
            ]) . ' ' .
            $this->faker->randomElement([
                'de Gestión', 'de Comercio', 'de Noticias', 'de Reservas', 'Web', 'Avanzado', 'de Análisis'
            ]),
            'description' => $this->faker->paragraph,
            'creator_id' => User::factory(),
            'status' => $this->faker->randomElement(['Activo', 'Completado', 'Archivado']),
            'image_url' => 'https://inmarketing.co/wp-content/uploads/2019/04/factores-que-determinan-el-crecimiento-de-un-negocio-2-baja.jpg',
            'theme' => $this->faker->randomElement(['Portfolio','Juegos', 'Entretenimiento', 'Social', 'Tiendas', 'Negocios']),
            'technologies' => implode(', ', $this->faker->randomElements([
                'HTML5', 'CSS3', 'JavaScript', 'React', 'Angular', 'Vue.js',
                'Node.js', 'Laravel', 'Django', 'Ruby on Rails', 'Tailwind CSS',
                'Bootstrap', 'PHP', 'MySQL', 'PostgreSQL', 'MongoDB',
                'TypeScript', 'Express.js', 'GraphQL', 'REST API', 'Docker', 'Webpack',
                'SASS', 'Git', 'Figma'
            ], $this->faker->numberBetween(3, 6))),
            'level' => $this->faker->randomElement(['Principiante', 'Intermedio', 'Avanzado', 'Experto']),
            'goal' => $this->faker->sentence,
            'duration' => $this->faker->randomElement(['3 meses', '6 meses', '1 año']),
            'team_size' => $this->faker->numberBetween(1, 10),
            'repository_url' => $this->faker->url,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
