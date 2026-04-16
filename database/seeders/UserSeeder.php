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
            'administrator_id' => null,
            'email' => 'root@root.com',
            'password' => bcrypt('123'),
            'active' => 1,
        ]);

        sleep(1);
        \App\Models\User::factory(3)->create([
            'password' => bcrypt('123'),
        ]);

        sleep(1);
        \App\Models\User::factory(10)->create([
            'password' => bcrypt('123'),
        ]);

        sleep(1);
        \App\Models\User::factory(1000)->create([
            'password' => bcrypt('123'),
        ]);
    }
}
