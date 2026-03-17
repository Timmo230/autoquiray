<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class CreateUserController extends Controller
{
    public function get(){
        $permissions = DB::table('permissions')
        ->select(['permission', 'id'])
        ->get()
        ->toArray();

        $userTypes = DB::table('types')
        ->select(['id', 'type'])
        ->get()
        ->toArray();

        return view('admin.createUser', [
            'permissions' => $permissions,
            'userTypes' => $userTypes
        ]);
    }

    public function upload(Request $request){
        $userType = $request->input('userType');
        $nameUser = $request->input('nameUser');
        $email =  $request->input('email');
        $documentType = $request->input('documentType');
        $documentValue =  $request->input('documentValue');

        $userID = Auth::id();
        $newUserID = (string) Str::uuid();

        $now = now();

        DB::transaction(function() use ($userType, $nameUser, $email,
        $documentType, $documentValue, $request,
        $userID, $newUserID, $now){
            DB::table('users')
            ->insert([
                'id' => $newUserID,
                'administrator_id' => $userID,
                'document_id' => $documentValue,
                'document_type' => $documentType,
                'name' => $nameUser,
                'email' => $email,
                'active' => true,
                'password' => Hash::make('123'),
                'created_at' => $now,
                'updated_at' => $now
            ]);

            DB::table('user_is_assigned_types')
            ->insert([
                'user_id' => $newUserID,
                'type_id' => $userType,
                'created_at' => $now,
                'updated_at' => $now
            ]);

            if($userType ==  1){
                
                $amountTutions = $request->input('amountTutions');
                $tutions = $request->input('tuitions');
                DB::table('students')
                ->insert([
                    'user_id' => $newUserID,
                    'created_at' => $now,
                    'updated_at' => $now
                ]);

                foreach($tutions as $tution){
                    $paid = null;

                    if($tution['is_paid']) $paid = 'matriculado';
                    else $paid = 'pendientePago';

                    DB::table('tutions')
                    ->insert([
                        'administrator_id' => $userID,
                        'student_id' => $newUserID,
                        'permission_id' => $tution['permission_id'],
                        'date' => $now,
                        'start_date' => $tution['starts_at'],
                        'max_end_date' => $tution['ends_at'],
                        'status' => $paid,
                        'price' => $tution['price'],
                        'created_at' => $now,
                        'updated_at' => $now
                    ]);
                }
            }
            else{
                $salary = $request->input('salary');
                DB::table('employees')
                ->insert([
                    'user_id' => $newUserID,
                    'salary' => $salary,
                    'created_at' => $now,
                    'updated_at' => $now
                ]);

                if($userType ==  2){
                    DB::table('teachers')
                    ->insert([
                        'employees_id' => $newUserID,
                        'created_at' => $now,
                        'updated_at' => $now
                    ]);
                }
                else{
                    DB::table('administrators')
                    ->insert([
                        'employees_id' => $newUserID,
                        'created_at' => $now,
                        'updated_at' => $now
                    ]);
                }
            }
        }, 10);

        return response()->json(['success' => true]);
    }
}
