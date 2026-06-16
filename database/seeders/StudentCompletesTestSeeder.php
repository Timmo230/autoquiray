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
        $studentsCount = Student::query()->count();
        $testsCount = Test::query()->count();
        $target = min(420, $studentsCount * $testsCount);
        $created = 0;

        while ($created < $target) {
            $student = Student::inRandomOrder()->first();
            $test    = Test::inRandomOrder()->first();

            $register = StudentCompletesTest::firstOrCreate(
                [
                    'student_id' => $student->user_id,
                    'test_id'    => $test->id,
                ],
                [
                    'last_note' => $test->max_note >= 27
                        ? rand(max(20, $test->max_note - 6), $test->max_note)
                        : rand(max(5, $test->max_note - 3), $test->max_note),
                    'time' => rand(0, $test->max_time * 60),
                ]
            );

            if ($register->wasRecentlyCreated) {
                $created++;
            }
        }
    }
}
