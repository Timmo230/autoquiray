<?php

namespace Database\Factories;

use App\Models\Employees;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

use function PHPUnit\Framework\isNull;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employees>
 */
class EmployeesFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => '123',
            'salary' => $this->faker->randomFloat(2, 1500, 4500),
            'created_at'    => now(),
            'updated_at'    => now(),
        ];
    }
}
