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
        $faker = fake('es_ES');
        $slots = [
            ['09:00:00', '10:30:00'],
            ['10:30:00', '12:00:00'],
            ['12:00:00', '13:30:00'],
            ['16:00:00', '17:30:00'],
            ['17:30:00', '19:00:00'],
            ['19:00:00', '20:30:00'],
        ];
        [$start, $end] = $faker->randomElement($slots);
        $date = $faker->dateTimeBetween('+1 day', '+10 weeks');

        return [
            'administrator_id' => Administrator::inRandomOrder()->value('employees_id'),
            'date' => $date->format('Y-m-d'),
            'start_time' => $start,
            'end_time' => $end,
        ];
    }
}
