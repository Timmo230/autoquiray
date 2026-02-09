<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\select;

class haciendoTestController extends Controller
{
    public function showquestions(Request $request){
        $test = $request->query('id');

        $testInfo = DB::table('tests')->where('id', '=', $test)->first();

        $results = DB::table('question_tests', 'qt')
            ->join('options as o', 'o.question_id', '=', 'qt.id')
            ->select()
            ->where('qt.test_id', '=', $test)
            ->get();
        
        $questions = $results->groupBy('question_id')->values();

        return view('student.complete_test', [
            'questions' => $questions,
            'test' => $testInfo,
        ]);
    }
}