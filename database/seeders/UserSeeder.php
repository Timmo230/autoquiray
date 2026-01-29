<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rootUser = \App\Models\User::factory()->create([
            'name' => 'root',
            'document_id' => '00000000X',
            'document_type' => 'DNI',
            'type' => 'administrator',
            'administrator_id' => null,
            'email' => 'root@root.com',
            'password' => bcrypt('123'),
        ]);

        $administrators = \App\Models\User::factory(3)->create([
            'type' => 'administrator',
            'password' => bcrypt('123'),
        ]);

        $teachers = \App\Models\User::factory(10)->create([
            'type' => 'teacher',
            'password' => bcrypt('123'),
        ]);

        $students = \App\Models\User::factory(1000)->create([
            'type' => 'student',
            'password' => bcrypt('123'),
        ]);
    }
}
