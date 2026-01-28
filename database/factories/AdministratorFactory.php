<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Employees;
use App\Models\Administrator;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Administrator>
 */
class AdministratorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $employee = Employees::whereHas('user', function ($query){
            $query->where('type', 'administrator');
        })->whereDoesntHave('administrator')->first();

        return [
            'employees_id'   => $employee->id,
        ];
    }
}
