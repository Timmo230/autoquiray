<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Services\EmployeesPlaceService as service;

class EmployeesPlaceController extends Controller
{
    protected function getTeacherQuestionsCollection(Request $request)
    {
        $search = trim((string) $request->input('search', ''));
        $status = $request->input('status', 'all');

        $studentQuestions = DB::table('student_questions as sq')
            ->join('users as student_u', 'student_u.id', '=', 'sq.student_id')
            ->leftJoin('answers as a', 'a.question_id', '=', 'sq.id')
            ->leftJoin('teachers as t', 't.employees_id', '=', 'a.teacher_id')
            ->leftJoin('users as teacher_u', 'teacher_u.id', '=', 't.employees_id')
            ->when($search !== '', function ($q) use ($search) {
                $q->where(function ($nested) use ($search) {
                    $nested->where('student_u.name', 'LIKE', "%{$search}%")
                        ->orWhere('student_u.email', 'LIKE', "%{$search}%")
                        ->orWhere('sq.affair', 'LIKE', "%{$search}%")
                        ->orWhere('sq.message', 'LIKE', "%{$search}%")
                        ->orWhere('a.message', 'LIKE', "%{$search}%")
                        ->orWhere('teacher_u.name', 'LIKE', "%{$search}%");
                });
            })
            ->select(
                'sq.id',
                'sq.affair',
                'sq.message',
                'sq.date_sent',
                'student_u.id as student_id',
                'student_u.name as student_name',
                'student_u.email as student_email',
                DB::raw('COUNT(a.id) as answers_count'),
                DB::raw('COUNT(DISTINCT a.teacher_id) as teachers_count'),
                DB::raw('MAX(a.date_sent) as last_answer_at')
            )
            ->groupBy(
                'sq.id',
                'sq.affair',
                'sq.message',
                'sq.date_sent',
                'student_u.id',
                'student_u.name',
                'student_u.email'
            )
            ->when($status === 'answered', function ($q) {
                $q->havingRaw('COUNT(a.id) > 0');
            })
            ->when($status === 'pending', function ($q) {
                $q->havingRaw('COUNT(a.id) = 0');
            })
            ->orderByRaw('CASE WHEN COUNT(a.id) = 0 THEN 0 ELSE 1 END ASC')
            ->orderByDesc('sq.date_sent')
            ->limit(40)
            ->get();

        $answersByQuestion = $studentQuestions->isNotEmpty()
            ? DB::table('answers as a')
                ->leftJoin('teachers as t', 't.employees_id', '=', 'a.teacher_id')
                ->leftJoin('users as teacher_u', 'teacher_u.id', '=', 't.employees_id')
                ->whereIn('a.question_id', $studentQuestions->pluck('id'))
                ->orderBy('a.date_sent')
                ->select(
                    'a.id',
                    'a.question_id',
                    'a.message',
                    'a.date_sent',
                    'a.teacher_id',
                    DB::raw("COALESCE(teacher_u.name, 'Profesor') as teacher_name")
                )
                ->get()
                ->groupBy('question_id')
            : collect();

        return $studentQuestions->map(function ($question) use ($answersByQuestion) {
            $question->answers = $answersByQuestion->get($question->id, collect())->values();
            return $question;
        });
    }

    public function getStudents(Request $request){

        $search = $request->input('search');

        $alumnos = DB::table('users as u')
        ->join('students as st', 'st.user_id', '=', 'u.id')
        ->leftJoin('student_completes_tests as sct', 'sct.student_id', '=', 'st.user_id')
        ->when($search, function ($q) use ($search) {
            return $q->where('u.email', 'LIKE', "%{$search}%");
        })
        ->select(
            'u.name',
            'u.email',
            DB::raw('COUNT(sct.test_id) as total_examenes'),
            DB::raw('SUM(CASE WHEN sct.last_note >= 27 THEN 1 ELSE 0 END) as aprobados')
        )
        ->groupBy('u.id', 'u.name', 'u.email')
        ->limit(10)
        ->get()
        ->map(function ($item) {
            $item->porcentaje_aprobados = $item->total_examenes > 0
                ? round(($item->aprobados / $item->total_examenes) * 100, 2)
                : 0;
            return $item;
        })
        ->toArray();

        return view('teacher.dashboard', [
            'alumnos' => $alumnos,
        ]);
    }

    public function getstudents(Request $request){
        return $this->getStudents($request);
    }

    public function getQuestions(Request $request)
    {
        return view('teacher.questions', [
            'questions' => $this->getTeacherQuestionsCollection($request),
            'filters' => [
                'search' => $request->input('search', ''),
                'status' => $request->input('status', 'all'),
            ],
        ]);
    }

    public function answerStudentQuestion(Request $request)
    {
        $request->validate([
            'question_id' => 'required|string|exists:student_questions,id',
            'message' => 'required|string|max:512',
        ]);

        DB::table('answers')->insert([
            'id' => (string) Str::uuid(),
            'teacher_id' => Auth::id(),
            'question_id' => $request->input('question_id'),
            'message' => trim($request->input('message')),
            'date_sent' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Respuesta enviada correctamente.');
    }

    public function getTeachers(Request $request){
        $search = $request->input('search');

        $teachers = service::getTeachers($search);

        return view('admin.dashboard', [
            'teachers' => $teachers,
        ]);
    }

    public function getStats(Request $request){
        try {
            $teacherID = $request->input('teacherID');
            $solicited = $request->input('solicited');

            $answers = 0;
            $tests = 1;
            $classes = 2;

            $teacherName = service::getTeacherName($teacherID);

            $result = match ((int) $solicited) {
                $answers => service::getAnswers($teacherID),
                $tests => service::getTests($teacherID),
                $classes => service::getClasses($teacherID),
                default => false,
            };

            $output = $result === false ? 
                response()->json([
                    'ok' => false,
                    'message' => 'No se encontraron datos',
                    'data' => []
                ], 404) :
                response()->json([
                    'ok' => true,
                    'message' => 'Datos cargados correctamente',
                    'data' => $result,
                    'teacherName' => $teacherName
                ], 200);
            
            return $output;

        } catch (\Throwable $e) {
            return response()->json([
                'ok' => false,
                'message' => 'Error 500',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getDetails(Request $request){
        try {
            $elementID = $request->input('elementID');
            $solicited = $request->input('solicited');

            $answers = 0;
            $tests = 1;
            $classes = 2;

            $result = match ((int) $solicited) {
                $answers => service::getAnswersDetails($elementID),
                $tests => service::getTestsDetails($elementID),
                $classes => service::getClassesDetails($elementID),
                default => false,
            };

            
            $output = $result === false ? 
                response()->json([
                    'ok' => false,
                    'message' => 'No se encontraron datos',
                    'data' => []
                ], 404) :
                response()->json([
                    'ok' => true,
                    'message' => 'Datos cargados correctamente',
                    'data' => $result
                ], 200);
            
            return $output;

        } catch (\Throwable $e) {
            return response()->json([
                'ok' => false,
                'message' => 'Error 500',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
