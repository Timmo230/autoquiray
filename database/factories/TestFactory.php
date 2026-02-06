<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Teacher;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Test>
 */
class TestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'teacher_id' => Teacher::inRandomOrder()->first(),
            'title' => $this->faker->sentence(),
            'max_note' => $this->faker->randomElement([20, 30]),
            'max_time' => $this->faker->randomElement([20, 30]),
            'type' => $this->faker->randomElement(['senales', 'circulacion', 'seguridad', 'dgt']),
        ];
    }
}
