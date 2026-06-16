<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Exam;
use App\Models\Permission;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exam>
 */
class ExamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $randomPermission = Permission::inRandomOrder()->first();
        $faker = fake('es_ES');
        $examDate = $faker->dateTimeBetween('+1 week', '+5 months');
        
        return [
            'id' => (string) Str::uuid(),
            'permission_id' => $randomPermission->id,
            'date' => $examDate->format('Y-m-d'),
            'start_time' => $faker->randomElement(['08:30:00', '10:00:00', '11:30:00', '16:00:00', '17:30:00']),
            'type' => $faker->randomElement(['theorist', 'practical']),
            'price' => $faker->randomElement([35.00, 42.50, 55.00, 78.00, 95.00]),
        ];
    }
}
