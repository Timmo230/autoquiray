<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function upload(){

    }
}
