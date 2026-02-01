<?php

namespace Database\Factories;

use App\Models\Registers;
use Illuminate\Database\Eloquent\Factories\Factory;

class RegistersFactory extends Factory
{
    protected $model = Registers::class;

    public function definition(): array
    {
        return [
            'note' => $this->faker->optional()->numberBetween(20, 30),
        ];
    }
}