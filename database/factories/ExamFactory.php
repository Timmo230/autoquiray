<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Exam;
use App\Models\Permission;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exam>
 */
class ExamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $randomPermission = Permission::inRandomOrder()->first();
        
        return [
            'id' => fake()->bothify('????????-???????-???????-???????'),
            'permission_id' => $randomPermission->id,
            'date' => $this->faker->date('2025-01-01', '2027-12-31'),
            'start_time' => $this->faker->dateTimeBetween('08:00:00', '23:00:00')->format('H:i:s'),
            'type' => $this->faker->randomElement(['theorist', 'practical']),
            'price' => $this->faker->randomFloat(2, 10, 30),
        ];
    }
}
