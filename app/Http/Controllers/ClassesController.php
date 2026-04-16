<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ClassesController extends Controller
{
    public function get(Request $request){
        $userID = Auth::id();
        $today = now()->toDateString();
        
        //Clases disponibles para reservar
        $query = DB::table('classes')
        ->join('timetables', 'timetables.id', '=', 'classes.timetable_id')

        ->join('teachers', 'teachers.employees_id', '=', 'classes.teacher_id')
        ->join('employees', 'employees.user_id', '=', 'teachers.employees_id')
        ->join('users', 'users.id', '=', 'employees.user_id')

        ->leftJoin('students_reserves_classes as src', 'src.class_id', '=', 'classes.id')

        ->leftJoin('students_reserves_classes as my_src', function ($join) use ($userID) {
            $join->on('my_src.class_id', '=', 'classes.id')
                ->where('my_src.student_id', '=', $userID);
        })

        ->whereDate('timetables.date', '>', $today)
        ->whereNull('my_src.student_id');

        //Filtros
        if ($request->filled('title')) {
            $query->where('classes.title', 'like', '%' . $request->title . '%');
        }

        if ($request->filled('teacher')) {
            $query->where('users.name', 'like', '%' . $request->teacher . '%');
        }

        if ($request->filled('date')) {
            $query->whereDate('timetables.date', $request->date);
        }

        if ($request->filled('limit') && is_numeric($request->limit)) {
            $limit = min((int) $request->limit, 100);
            $query->limit($limit);
        }
        else{
            $query->limit(20);
        }

        $classes = $query
        ->groupBy(
            'classes.id',
            'classes.timetable_id',
            'classes.teacher_id',
            'classes.title',
            'classes.max_students',
            'classes.created_at',
            'timetables.date',
            'classes.updated_at',
            'timetables.start_time',
            'timetables.end_time',
            'users.name'
        )

        ->havingRaw('COUNT(src.student_id) < classes.max_students')

        ->orderBy('timetables.date')
        ->orderBy('timetables.start_time')

        ->select(
            'classes.*',
            DB::raw("DATE_FORMAT(timetables.date, '%d/%m/%Y') as date"),
            DB::raw('DATE_FORMAT(timetables.start_time, "%H:%i") as start_time'),
            DB::raw('DATE_FORMAT(timetables.end_time, "%H:%i") as end_time'),
            'users.name as name',
            DB::raw('COUNT(src.student_id) as reserved_count'),
            DB::raw('(classes.max_students - COUNT(src.student_id)) as available_slots')
        )
        ->get();


        //Clases reservadas por el usuario
        $reservedClasses = DB::table('classes')
        ->join('timetables', 'timetables.id', '=', 'classes.timetable_id')
        ->join('teachers', 'teachers.employees_id', '=', 'classes.teacher_id')
        ->join('employees', 'employees.user_id', '=', 'teachers.employees_id')
        ->join('users', 'users.id', '=', 'employees.user_id')
        ->join('students_reserves_classes as my_src', function ($join) use ($userID) {
            $join->on('my_src.class_id', '=', 'classes.id')
                ->where('my_src.student_id', '=', $userID);
        })

        ->orderByRaw("
            CASE
                WHEN DATE(timetables.date) = ? THEN 0
                WHEN DATE(timetables.date) > ? THEN 1
                ELSE 2
            END
        ", [$today, $today])

        ->orderByRaw("
            CASE
                WHEN DATE(timetables.date) >= ? THEN CONCAT(timetables.date,' ',timetables.start_time)
            END ASC
        ", [$today])

        ->orderByRaw("
            CASE
                WHEN DATE(timetables.date) < ? THEN CONCAT(timetables.date,' ',timetables.start_time)
            END DESC
        ", [$today])

        ->select(
            'classes.*',
            'timetables.date as raw_date',
            'timetables.start_time as raw_start_time',
            'timetables.end_time as raw_end_time',
            DB::raw("DATE_FORMAT(timetables.date, '%d/%m/%Y') as date"),
            DB::raw('DATE_FORMAT(timetables.start_time, "%H:%i") as start_time'),
            DB::raw('DATE_FORMAT(timetables.end_time, "%H:%i") as end_time'),
            'users.name as name',
            'my_src.created_at as reserved_at'
        )
        ->get();
    
        return view('student.classes',[
            'classes' => $classes,
            'reservedClasses' => $reservedClasses
        ]);
    }

    public function reservesClass(Request $request){
        $userID = Auth::id();
        if (!$userID) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }
        if(!$request->filled('idClass')) {
            return response()->json(['error' => 'No clase especificada'], 422);
        }

        $idClass = (int) $request->input('idClass');

        $class = DB::table('classes')
        ->join('timetables', 'timetables.id', '=', 'classes.timetable_id')
        ->leftJoin('students_reserves_classes as src', 'src.class_id', '=', 'classes.id')
        ->where('classes.id', $idClass)
        ->whereRaw("TIMESTAMP(timetables.date, timetables.start_time) > NOW()")
        ->groupBy(
            'classes.id',
            'classes.max_students',
            'timetables.date',
            'timetables.start_time'
        )
        ->select(
            'classes.id',
            'classes.max_students',
            DB::raw('COUNT(src.student_id) as reserved_count')
        )
        ->first();

        if (!$class) {
            return response()->json(['error' => 'La clase no esta disponible'], 404);
        }

        $alreadyReserved = DB::table('students_reserves_classes')
        ->where('student_id', $userID)
        ->where('class_id', $idClass)
        ->exists();

        if ($alreadyReserved) {
            return response()->json(['error' => 'Ya estabas apuntado a esta clase'], 409);
        }

        if ($class->reserved_count >= $class->max_students) {
            return response()->json(['error' => 'La clase ya no tiene plazas disponibles'], 409);
        }

        DB::table('students_reserves_classes')
        ->insert([
            'student_id' => $userID,
            'class_id' => $idClass,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json(['success' => true]);
    }

    public function cancelReservation(int $classId)
    {
        $userID = Auth::id();
        if (!$userID) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }

        $reservation = DB::table('students_reserves_classes as src')
        ->join('classes', 'classes.id', '=', 'src.class_id')
        ->join('timetables', 'timetables.id', '=', 'classes.timetable_id')
        ->where('src.student_id', $userID)
        ->where('src.class_id', $classId)
        ->select(
            'src.class_id',
            DB::raw("TIMESTAMP(timetables.date, timetables.start_time) as starts_at")
        )
        ->first();

        if (!$reservation) {
            return response()->json(['error' => 'Reserva no encontrada'], 404);
        }

        if (now()->gte(\Carbon\Carbon::parse($reservation->starts_at))) {
            return response()->json(['error' => 'No puedes desapuntarte de una clase que ya ha empezado'], 422);
        }

        DB::table('students_reserves_classes')
        ->where('student_id', $userID)
        ->where('class_id', $classId)
        ->delete();

        return response()->json(['success' => true]);
    }
}
