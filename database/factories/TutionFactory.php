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
        $faker = fake('es_ES');
        $startDate = $faker->dateTimeBetween('-1 month', '+1 month');
        $maxEndDate = (clone $startDate)->modify('+1 year');

        return [
            'administrator_id' => Administrator::inRandomOrder()->first()?->employees_id,
            'student_id'       => Student::inRandomOrder()->first()?->user_id,
            'permission_id'    => Permission::inRandomOrder()->first()?->id,
            'date' => $faker->date(),
            'start_date'   => $startDate->format('Y-m-d'),
            'max_end_date' => $maxEndDate->format('Y-m-d'),
            'status' => $faker->randomElement(['pendientePago', 'matriculado', 'matriculado', 'finalizado']),
            'price' => $faker->randomElement([189.00, 229.00, 249.00, 289.00, 325.00]),
        ];
    }
}
