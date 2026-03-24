<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Services\EmployeesPlaceService as service;

class EmployeesPlaceController extends Controller
{
    public function getstudents(Request $request){

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
