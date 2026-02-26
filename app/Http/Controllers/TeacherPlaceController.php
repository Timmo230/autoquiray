<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherPlaceController extends Controller
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
}
