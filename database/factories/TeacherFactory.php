<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Employees;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Teacher>
 */
class TeacherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $employee = Employees::whereHas('user', function ($query){
            $query->where('type', 'teacher');
        })->whereDoesntHave('teacher')->first();

        return [
            'employees_id'   => $employee->id,
        ];
    }
}
