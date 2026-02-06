<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    public $incrementing = false;
    protected $keyType = 'string';
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id'   => fake()->bothify('????????-???????-???????-???????'),
            'document_id'   => fake()->bothify('########?'),
            'document_type' => fake()->randomElement(['DNI', 'passport']),
            'name'          => fake()->name(),
            'email'         => fake()->unique()->safeEmail(),
            'active'        => fake()->boolean(90),
            'password'      => bcrypt('password'),
            'administrator_id' => null,
            'created_at'    => now(),
            'updated_at'    => now(),
        ];
    }
}
