<?php

namespace App\Http\Controllers;

use Illuminate\Container\Attributes\Auth as a;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class hacerTestController extends Controller
{
    public function showTests(Request $request){
        $type = $request->query('type');

        if(!in_array($type, ['senales', 'circulacion', 'seguridad', 'dgt'])){
            return redirect()->route('student.testType');
        }

        $testRequired = DB::table('tests', 't')
            ->join('teachers as tch', 'tch.employees_id', '=', 't.teacher_id')
            ->join('employees as em', 'em.user_id', '=', 'tch.employees_id')
            ->join('users as u', 'u.id', '=', 'em.user_id')
            ->where('type', '=', $type)
            ->select(['t.*', 'u.name'])
            ->get();

        $testsOfStudent = DB::table('tests', 't')
            ->join('student_completes_tests as sct', 'sct.test_id', '=', 't.id')
            ->where('sct.student_id', '=', Auth::user()->id)
            ->select('t.id', 'sct.last_note', 'sct.test_id')
            ->get();
        
        return view('student.test', [
            'tests' => $testRequired,
            'categoria' => $type,
            'testsOfStudent' => $testsOfStudent,
        ]);
    }
}