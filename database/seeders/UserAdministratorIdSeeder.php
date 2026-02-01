<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserAdministratorIdSeeder extends Seeder
{
    public function run(): void
    {
        $users = \App\Models\User::whereNull('administrator_id')->get();
        $admins = \App\Models\Administrator::all();

        foreach ($users as $user) {
            $user->update([
                'administrator_id' => $admins->random()->employees_id
            ]);
        }
    }
}
