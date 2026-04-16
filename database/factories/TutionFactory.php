<?php

namespace Database\Factories;

use App\Models\Tution;
use App\Models\Administrator;
use App\Models\Student;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;

class TutionFactory extends Factory
{
    protected $model = Tution::class;

    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-1 month', '+1 month');
        $maxEndDate = (clone $startDate)->modify('+1 year');

        return [
            'administrator_id' => Administrator::inRandomOrder()->first()?->employees_id,
            'student_id'       => Student::inRandomOrder()->first()?->user_id,
            'permission_id'    => Permission::inRandomOrder()->first()?->id,
            'date'         => $this->faker->date(),
            'start_date'   => $startDate->format('Y-m-d'),
            'max_end_date' => $maxEndDate->format('Y-m-d'),
            'status' => $this->faker->randomElement(['pendientePago', 'matriculado', 'expirado', 'finalizado']),
            'price' => $this->faker->randomFloat(2, 100, 1000),
        ];
    }
}