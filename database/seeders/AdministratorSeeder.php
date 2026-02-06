<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employees;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    protected static $users = null;
    public function run(): void
    {
        if(is_null(self::$users)){
            self::$users = Employees::orderBy('created_at', 'asc')
                ->pluck('user_id')->toArray();
        }

        for($index = 0; $index < 4; $index++){
            \App\Models\Administrator::factory()->create([
                'employees_id' => self::$users[$index],
            ]);
        }
    }
}
