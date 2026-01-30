<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Student;
use App\Models\Exam;
use App\Models\Registers;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class RegistersFactory extends Factory
{
    protected $model = Registers::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $studentCount = Student::count();
        $examCount = Exam::count();

        if ($studentCount === 0 || $examCount === 0) {
            throw new \Exception("Error en Autoquiray: No puedes crear registros si no hay alumnos o exámenes previos.");
        }
        do{
            $studentId = Student::inRandomOrder()->first();
            $examId = Exam::inRandomOrder()->first();

            $exist = \App\Models\Registers::where([
                ['student_id', '=', $s->id ?? $studentId], 
                ['exam_id',    '=', $e->id ?? $examId]
            ])->exists();
        } while($exist);

        return [
            'student_id' => $studentId,
            'exam_id' => $examId,
        ];
    }
}
