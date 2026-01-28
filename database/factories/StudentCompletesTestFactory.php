<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Student;
use App\Models\Test;
use App\Models\StudentCompletesTest;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StudentCompletesTest>
 */
class StudentCompletesTestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        do{
            $studentId = Student::inRamdomOrder()->first()?->id;
            $testId = Test::inRandomOrder()->first()?->id;;

            if (!$studentId || !$testId) {
                throw new \Exception("¡Cuidado! Necesitas tener al menos un test y un student en la base de datos antes de usar este Factory.");
            }

            $exist = StudentCompletesTest::where('student_id', $studentId)
            ->where('test_id', $testId)->exist();
        } while($exist);

        return [
            'student_id' => $studentId->id,
            'test_id' => $testId->id,
            'last_note' => $this->faker->numberBetween(1, 30),
        ];
    }
}
