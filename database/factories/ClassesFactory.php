<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Teacher;
use App\Models\Timetable;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Classes>
 */
class ClassesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'teacher_id' => Teacher::inRandomOrder()->first(),
            'timetable_id' => Timetable::inRandomOrder()->first(),
            'title' => $this->faker->sentence(6),
            'maximun_student' => $this->faker->numberBetween(1, 30),
        ];
    }
}
