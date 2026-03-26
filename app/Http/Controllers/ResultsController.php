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
            $time = $request->input('time');

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

            $correctas = DB::table('question_tests')
                ->where('test_id', '=', $test_id)
                ->pluck('correct_option_id')
                ->toArray();

            $note = 0;

            foreach ($respuestas as $questionId => $optionId) {
                if ($optionId) {
                    $data[] = [
                        'student_id' => $user_id,
                        'option_id'  => $optionId,
                        'created_at' => $now,
                        'updated_at' => $now 
                    ];
                }

                if(in_array($optionId, $correctas)) $note++;
            }
            
            

            if (!empty($data)) {
                DB::table('student_selects_options')->insert($data);
                DB::table('student_completes_tests')->insert([
                    'student_id' => $user_id,
                    'test_id' => $test_id,
                    'last_note' => $note,
                    'time' => $time,
                    'created_at' => $now,
                    'updated_at' => $now
                ]);
            }

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            return response()->json(['error_general' => $e->getMessage()], 500);
        }
    }

    public function get(Request $request)
    {
        $testId = $request->query('id');
        $userId = Auth::id();

        $row = DB::table('student_completes_tests')
            ->where('student_id', '=', $userId)
            ->where('test_id', '=', $testId)
            ->first();

        if (!$row) return redirect('/')->with('error', 'No hay resultados para este test.');

        $testData = DB::table('tests')
            ->where('id', '=', $testId)
            ->first();

        $max_note_value = $testData->max_note; 
        
        $successes = $row->last_note;
        
        $failed = $max_note_value - $successes;
        
        $time = $row->time;

        return view('student.result', [
            'testId' => $testId,
            'successes' => $successes,
            'time' => $time,
            'failed' => $failed,
            'max_note' => $max_note_value,
        ]);
    }

    public function coorectTests(Request $request){
        $user_id = Auth::id();
        $test_id = $request->query('id');

        $exist =  DB::table('student_completes_tests')
            ->where('student_id', '=', $user_id)
            ->where('test_id', '=', $test_id)
            ->exists();
        
        if(!$exist) return redirect('/')->with('error', 'No encontrado');

        $testInfo = DB::table('tests')->where('id', '=', $test_id)->first();

        $results = DB::table('question_tests', 'qt')
            ->join('options as o', 'o.question_id', '=', 'qt.id')
            ->select()
            ->where('qt.test_id', '=', $test_id)
            ->get();
        
        $questions = $results->groupBy('question_id')->values();

        $optionsSelected = DB::table('student_selects_options', 'sso')
            ->join('options as o', 'sso.option_id', '=', 'o.id')
            ->join('question_tests as qt', 'qt.id', '=', 'o.question_id')
            ->where('qt.test_id', '=', $test_id)
            ->where('sso.student_id', '=', $user_id)
            ->select([
                'sso.option_id as seleccionada', 
                'qt.correct_option_id as correcta',
                'qt.id as pregunta_id'
            ])
            ->get()
            ->toArray();

        return view('student.showCorrectedTest', [
            'questions' => $questions,
            'test' => $testInfo,
            'optionsSelected' => $optionsSelected
        ]);
    }
}