<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $luck = fake()->numberBetween(1, 100);

        $type = match (true) {
            $luck <= 70 => 'student',
            $luck <= 90 => 'teacher',
            default     => 'administrator',
        };
        return [
            'document_id'   => fake()->bothify('########?'),
            'document_type' => fake()->randomElement(['DNI', 'passport']),
            'name'          => fake()->name(),
            'email'         => fake()->unique()->safeEmail(),
            'type'          => $type,
            'active'        => fake()->boolean(90),
            'password'      => bcrypt('password'),
            'administrator_id' => null,
            'created_at'    => now(),
            'updated_at'    => now(),
        ];
    }
}
