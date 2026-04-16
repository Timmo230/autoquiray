<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Administrator;
use App\Models\Timetable;

class TimetableFactory extends Factory
{
    protected $model = Timetable::class;

    public function definition(): array
    {
        $start = $this->faker->time('H:i:s');
        $end = $this->faker->time('H:i:s');

        return [
            'administrator_id' => Administrator::inRandomOrder()->value('employees_id'),
            'date' => $this->faker->dateTimeBetween('2026-01-01', '2027-12-31'),
            'start_time' => $start,
            'end_time' => $end,
        ];
    }
}