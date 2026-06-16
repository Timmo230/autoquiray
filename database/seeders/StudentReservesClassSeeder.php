<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Classes;
use App\Models\StudentReservesClasse;

class StudentReservesClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $studentsCount = Student::query()->count();
        $classesCount = Classes::query()->count();
        $target = min(320, $studentsCount * $classesCount);
        $created = 0;

        while ($created < $target) {
            $student = Student::inRandomOrder()->first();
            $class    = Classes::inRandomOrder()->first();

            $register = StudentReservesClasse::firstOrCreate(
                [
                    'class_id' => $class->id,
                    'student_id'    => $student->user_id,
                ]
            );

            if ($register->wasRecentlyCreated) {
                $created++;
            }
        }
    }
}
