<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Student;
use App\Models\Classes;
use App\Models\StudentReservesClasse;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class StudentReservesClassFactory extends Factory
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
            $classId = Classes::inRandomOrder()->first()?->id;;

            if (!$studentId || !$classId) {
                throw new \Exception("¡Cuidado! Necesitas tener al menos un class y un student en la base de datos antes de usar este Factory.");
            }

            $exist = StudentReservesClasse::where('student_id', $studentId)
            ->where('class_id', $classId)->exist();
        } while($exist);

        return [
            'student_id' => $studentId->id,
            'class_id' => $classId->id,
        ];
    }
}
