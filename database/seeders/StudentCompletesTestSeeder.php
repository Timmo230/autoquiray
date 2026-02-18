<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Test;
use App\Models\StudentCompletesTest;

class StudentCompletesTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $created = 0;

        while ($created < 5000) {
            $student = Student::inRandomOrder()->first();
            $test    = Test::inRandomOrder()->first();

            $register = StudentCompletesTest::firstOrCreate(
                [
                    'student_id' => $student->user_id,
                    'test_id'    => $test->id,
                ],
                [
                    'last_note' => rand(20, 30),
                    'time' => rand(0, $test->max_time * 60),
                ]
            );

            if ($register->wasRecentlyCreated) {
                $created++;
            }
        }
    }
}
