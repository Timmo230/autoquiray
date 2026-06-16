<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class EmployeesSeeder extends Seeder
{
    protected static $users = null;
    public function run(): void
    {
        if(is_null(self::$users)){
            self::$users = DB::table('users as u')
                ->join('user_is_assigned_types as uat', 'u.id', '=', 'uat.user_id')
                ->join('types','uat.type_id','=','types.id')
                ->where('type', '!=', 'student')
                ->distinct()
                ->pluck('u.id')
                ->toArray();
        }

        foreach(self::$users as $user){
            \App\Models\Employees::factory()->create([
                'user_id' => $user,
            ]);
        }
    }
}
