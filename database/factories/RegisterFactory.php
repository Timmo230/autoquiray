<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Student;
use App\Models\Exam;
use App\Models\Registers;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class RegisterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        do{
            $studentId = Student::inRamdomOrder()->first();
            $examId = Exam::inRandomOrder()->first();

            $exist = Registers::where('student_id', $studentId)
            ->where('exam_id', $examId)->exist();
        } while($exist);

        return [
            'student_id' => $studentId->id,
            'exam_id' => $examId->id,
        ];
    }
}
