<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Student;
use App\Models\Employees;
use App\Models\Teacher;
use App\Models\Administrator;
use App\Models\UserIsAssignedTypes;

class MultiRoleUserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'multi@autoquiray.test'],
            [
                'id'               => fake()->bothify('????????-???????-???????-???????'),
                'name'             => 'Multi Role User',
                'document_id'      => '99999999Z',
                'document_type'    => 'DNI',
                'password'         => bcrypt('123'),
                'active'           => 1,
                'administrator_id' => null,
            ]
        );

        $userId = $user->id;

        // Assign all 3 roles (1=student, 2=teacher, 3=administrator)
        foreach ([1, 2, 3] as $typeId) {
            UserIsAssignedTypes::firstOrCreate([
                'user_id' => $userId,
                'type_id' => $typeId,
            ]);
        }

        Student::firstOrCreate(['user_id' => $userId]);

        Employees::firstOrCreate(
            ['user_id' => $userId],
            ['salary'  => 2500.00]
        );

        Teacher::firstOrCreate(['employees_id' => $userId]);

        Administrator::firstOrCreate(['employees_id' => $userId]);
    }
}
