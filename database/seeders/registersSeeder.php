<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Exam;
use App\Models\Registers;

class registersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $created = 0;

        while ($created < 1000) {
            $student = Student::inRandomOrder()->first();
            $exam    = Exam::inRandomOrder()->first();

            $register = Registers::firstOrCreate(
                [
                    'student_id' => $student->user_id,
                    'exam_id'    => $exam->getAttributes()['id'],
                ],
                [
                    'note' => rand(25, 30),
                ]
            );

            if ($register->wasRecentlyCreated) {
                $created++;
            }
        }
    }
}
