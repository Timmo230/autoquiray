<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Administrator;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TimeTable>
 */
class TimeTableFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'administrator_id' => Administrator::inRandomOrder()->first(),
            'date' => $this->faker->dateTimeBetween('2025-01-01', '2027-12-31'),
            'start_time' => $this->faker->dateTimeBetween('08:00:00', '23:00:00')->format('H:i:s'),
            'end_time' => $this->faker->dateTimeBetween('08:00:00', '23:00:00')->format('H:i:s'),
        ];
    }
}
