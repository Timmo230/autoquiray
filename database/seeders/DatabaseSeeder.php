<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Classes;
use App\Models\Registers;
use App\Models\Tution;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            PermissionSeeder::class,
            EmployeesSeeder::class,
            AdministratorSeeder::class,
            TeacherSeeder::class,
            UserAdministratorIdSeeder::class,
            StudentSeeder::class,
            ExamSeeder::class,
            registersSeeder::class,
            StudentQuestionSeeder::class,
            AnswerSeeder::class,
            TestSeeder::class,
            PermissionAreAssociatedTestSeeder::class,
            QuestionSeeder::class,
            OptionSeeder::class,
            StudentCompletesTestSeeder::class,
            TimetableSeeder::class,
            ClassSeeder::class,
            PermissionsAreToughtInClassesTableSeeder::class,
            StudentReservesClassSeeder::class,
            TutionSeeder::class,
        ]);
    
    }
}