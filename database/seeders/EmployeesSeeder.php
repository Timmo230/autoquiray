<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class EmployeesSeeder extends Seeder
{
    protected static $users = null;
    public function run(): void
    {
        if(is_null(self::$users)){
            self::$users = User::orderBy('created_at', 'asc')
                ->pluck('id')->toArray();
        }

        for($index = 0; $index < 14; $index++){
            \App\Models\Employees::factory()->create([
                'user_id' => self::$users[$index],
            ]);
        }
    }
}