<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $faker = fake('es_ES');

        return [
            'id' => (string) Str::uuid(),
            'document_id' => $faker->numerify('########') . strtoupper($faker->randomLetter()),
            'document_type' => $faker->randomElement(['DNI', 'DNI', 'DNI', 'passport']),
            'name' => $faker->name(),
            'email'         => fake()->unique()->safeEmail(),
            'active' => $faker->boolean(92),
            'password'      => bcrypt('password'),
            'administrator_id' => null,
            'created_at'    => now(),
            'updated_at'    => now(),
        ];
    }
}
