<?php

namespace Database\Factories;

use App\Models\Spot;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Spot>
 */
class SpotFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Spot::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement([
                'Madison Square Garden',
                'Staples Center',
                'Wembley Stadium',
                'Camp Nou',
                'Old Trafford',
                'Anfield',
                'Signal Iduna Park',
                'Allianz Arena',
                'San Siro',
                'Estadio Azteca',
                'Maracanã Stadium',
                'Tokyo Dome',
                'Philippine Arena',
                'Bell Centre',
                'Scotiabank Arena',
            ]),
            'location' => $this->faker->sentence,
            'capacity' => $this->faker->numberBetween(10, 1000),
            'description' => $this->faker->paragraph,
            'picture' => $this->faker->imageUrl(),
        ];
    }
}