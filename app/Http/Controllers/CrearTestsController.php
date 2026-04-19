<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use function Symfony\Component\Clock\now;

class CrearTestsController extends Controller
{
    public function crear_tests(Request $request){
        try {
            $titleTest = $request->input('titleTest');
            $typeTest = $request->input('typeTest');
            $maxTimeTest = $request->input('maxTimeTest');
            $numQuestionsTest = $request->input('numQuestionsTest');
            $questionsArray = $request->input('questionsArray');
            $userID = Auth::id();
            $idTest = (string) Str::uuid();

            DB::transaction(function () use ($titleTest, $typeTest,
            $maxTimeTest, $numQuestionsTest, $questionsArray, $userID,
            $idTest){

                DB::table('tests')
                ->insert([
                    'id' => $idTest,
                    'teacher_id' => $userID,
                    'title' => $titleTest,
                    'max_note' => $numQuestionsTest,
                    'max_time' => $maxTimeTest,
                    'type' => $typeTest,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                foreach($questionsArray as $question){
                    $idQestion = (string) Str::uuid();
                    $titleQuestion = $question['title'];
                    $correcOption = (int) $question['correct_option'];

                    $idsOptions = [];
                    $options = [];

                    foreach($question['options'] as $optionActual){
                        $idsOptions[] = (string) Str::uuid();
                        $options[] = $optionActual;
                    }

                    DB::table('question_tests')
                    ->insert([
                        'id' => $idQestion,
                        'test_id' => $idTest,
                        'teacher_id' => $userID,
                        'title' => $titleQuestion,
                        'correct_option_id' => $idsOptions[$correcOption],
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

                    for($i = 0; $i < count($options); $i++){
                        DB::table('options')
                        ->insert([
                            'id' => $idsOptions[$i],
                            'question_id' => $idQestion,
                            'option' => $options[$i],
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    }
                }
            }, 10);

            return response()->json([
                'success' => true,
                'message' => 'Test guardado correctamente.'
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo guardar el test.'
            ], 500);
        }
    }
}
