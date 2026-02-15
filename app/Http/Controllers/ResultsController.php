<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\StudentSelectsOption as select;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ResultsController extends Controller
{
    public function upload(Request $request)
    {
        try {
            $user_id = Auth::id();
            if (!$user_id) {
                return response()->json(['error' => 'Usuario no autenticado'], 401);
            }

            $respuestas = $request->input('responds');
            $test_id = $request->input('testId');

            $data = [];
            $now = now();

            $idsABorrar = DB::table('options as op')
                ->join('question_tests as qt', 'op.question_id', '=', 'qt.id')
                ->join('tests as t', 't.id', '=', 'qt.test_id')
                ->where('t.id', '=', $test_id)
                ->pluck('op.id');

            if ($idsABorrar->isNotEmpty()) {
                DB::table('student_selects_options')
                    ->where('student_id', $user_id)
                    ->whereIn('option_id', $idsABorrar)
                    ->delete();
            }

            $completesExist = DB::table('student_completes_tests')
                ->where('student_id', '=', $user_id)
                ->where('test_id', '=', $test_id)
                ->exists();

            if($completesExist){
                DB::table('student_completes_tests')
                    ->where('student_id', '=', $user_id)
                    ->where('test_id', '=', $test_id)
                    ->delete();
            }
            
            foreach ($respuestas as $questionId => $optionId) {
                if ($optionId) {
                    $data[] = [
                        'student_id' => $user_id,
                        'option_id'  => $optionId,
                        'created_at' => $now,
                        'updated_at' => $now 
                    ];
                }
            }
            
            $correctas = DB::table('question_tests', 'qt')
                ->join('tests as t', 't.id', '=', 'qt.test_id')
                ->where('t.id', '=', $test_id)
                ->pluck('qt.correct_option_id');

            $note = DB::table('question_tests')
                    ->whereIn('correct_option_id', $correctas)
                    ->count();

            if (!empty($data)) {
                DB::table('student_selects_options')->insert($data);
                DB::table('student_completes_tests')->insert([
                    'student_id' => $user_id,
                    'test_id' => $test_id,
                    'last_note' => $note,
                    'created_at' => $now,
                    'updated_at' => $now 
                ]);
            }

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            return response()->json(['error_general' => $e->getMessage()], 500);
        }
    }

    public function get(Request $request){
        $testId = $request->query('id');
        $userId = Auth::id();

        $row = DB::table('student_completes_tests')
            ->where('student_id', '=', $userId)
            ->where('test_id', '=', $testId)
            ->first();
        
        if (!$row) return redirect('/home')->with('error', 'No hay resultados para este test.');
        
        $testMaxNote = DB::table('tests')
            ->where('id', '=', $testId)
            ->first();
        
        $successes = $row->last_note;
        $failed = $testMaxNote - $successes;
        $time  = $row->time;

        return view('student.result', [
            'successes' => $successes,
            'time' => $time,
            'failed' => $failed,
            'max_note' => $testMaxNote,
        ]);
    }
}