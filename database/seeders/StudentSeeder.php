<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class StudentSeeder extends Seeder
{
    protected static $users = null;
    public function run(): void
    {
        if(is_null(self::$users)){
            self::$users = User::orderBy('created_at', 'asc')
                ->pluck('id')->toArray();
        }

        for($index = 13; $index < 1014; $index++){
            \App\Models\Student::factory()->create([
                'user_id' => self::$users[$index],
            ]);
        }
    }
}
