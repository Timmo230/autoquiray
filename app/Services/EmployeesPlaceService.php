<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class EmployeesPlaceService
{
    public static function getTeachers($search){
        return DB::table('users as u')
            ->join('employees as em', 'em.user_id', '=', 'u.id')
            ->join('teachers as t', 't.employees_id', '=', 'em.user_id')
            ->leftJoin('answers as ans', 'ans.teacher_id', '=', 't.employees_id')
            ->leftJoin('tests as test', 'test.teacher_id', '=', 't.employees_id')
            ->leftJoin('classes as c', 'c.teacher_id', '=', 't.employees_id')
            ->when($search, function ($q) use ($search) {
                return $q->where('u.email', 'LIKE', "%{$search}%");
            })
            ->select(
                'u.id',
                'u.name',
                'u.email',
                DB::raw('COUNT(DISTINCT ans.id) as total_respuestas'),
                DB::raw('COUNT(DISTINCT test.id) as total_tests'),
                DB::raw('COUNT(DISTINCT c.id) as total_classes')
            )
            ->groupBy('u.id', 'u.name', 'u.email')
            ->limit(10)
            ->get();
    }

    public static function getAnswers($teacherID){
        $output = [];
        $data = DB::table('answers as a')
                    ->join('teachers', 'employees_id', '=', 'teacher_id')
                    ->join('student_questions as sq', 'question_id', '=', 'sq.id')
                    ->join('users as u', 'u.id', '=', 'student_id')
                    ->where('employees_id', '=', $teacherID)
                    ->select([
                        'a.id as id',
                        'sq.affair as affair',
                        'u.name as user_name',
                        'a.menssage as answer',
                        'a.date_sent as date'
                    ])
                    ->get()
                    ->toArray();

        foreach ($data as $row) {
            $output[] = [
                'affair' => $row->affair,
                'name'   => $row->user_name,
                'answer' => $row->answer,
                'date'   => $row->date,
                'id' => $row->id
            ];
        }

        $output = $output === false ? [] : $output;
        
        return $output;
    }

    public static function getTests($teacherID){
        $output = [];
        $data = DB::table('tests as t')
                    ->join('teachers', 'employees_id', '=', 'teacher_id')
                    ->join('permissions_are_associated_test as pat','t.id','=', 'pat.test_id')
                    ->join('permissions as p','pat.permission_id','=', 'p.id')
                    ->where('employees_id', '=', $teacherID)
                    ->select([
                        't.id as id',
                        't.title as title',
                        't.type as type',
                        't.max_time as max_time',
                        't.max_note as max_note',
                        'permission as permission',
                        't.created_at as date'
                    ])
                    ->get()
                    ->toArray();

        foreach ($data as $row) {
            $id = $row->id;

            if (!isset($output[$id])) {
                $output[$id] = [
                    'id' => $id,
                    'title' => $row->title,
                    'type' => $row->type,
                    'max_time' => $row->max_time,
                    'max_note' => $row->max_note,
                    'permissions' => [],
                    'date' => $row->date,
                ];
            }
            $output[$id]['permissions'][] = $row->permission;
        }

        $output = $output === false ? [] : $output;

        return array_values($output);
    }

    public static function getClasses($teacherID){
        $output = [];

        $data = DB::table('classes as c')
                    ->join('teachers as t', 't.employees_id', '=', 'c.teacher_id')
                    ->join('timetables as tm', 'c.timetable_id', '=', 'tm.id')
                    ->join('permissions_are_tought_in_classes as ptc', 'c.id', '=', 'ptc.class_id')
                    ->join('permissions as p', 'p.id', '=', 'ptc.permission_id')
                    ->where('t.employees_id', '=', $teacherID)
                    ->select([
                        'c.id as id',
                        'c.title as title',
                        'c.max_students as max_students',
                        'tm.start_time as start_time',
                        'tm.end_time as end_time',
                        'tm.date as date',
                        'p.permission as permission',
                    ])
                    ->get()
                    ->toArray();

        foreach ($data as $row) {
            $id = $row->id;

            if (!isset($output[$id])) {

                $done = $row->date < now() ? true : false;

                $output[$id] = [
                    'id' => $id,
                    'title' => $row->title,
                    'max_students' => $row->max_students,
                    'start_time' => $row->start_time,
                    'end_time' => $row->end_time,
                    'permissions' => [],
                    'date' => $row->date,
                    'done' => $done
                ];
            }

            $output[$id]['permissions'][] = $row->permission;
        }
    
        $output = $output === false ? [] : $output;
        return array_values($output);
    }

    public static function getAnswersDetails($elementID){
        $output = [];
        $data = DB::table('answers as a')
            ->join('teachers as t', 't.employees_id', '=', 'a.teacher_id')
            ->join('student_questions as sq', 'a.question_id', '=', 'sq.id')
            ->join('users as student_u', 'student_u.id', '=', 'sq.student_id')
            ->join('users as teacher_u', 'teacher_u.id', '=', 't.employees_id')
            ->where('a.id', '=', $elementID)
            ->select([
                'sq.affair as affair',
                'student_u.name as student_name',
                'teacher_u.name as teacher_name',
                'sq.menssage as question',
                'a.menssage as answer',
                'a.date_sent as date_answer',
                'sq.date_sent as date_question'
            ])
            ->first();

        $output = [
            'affair' => $data->affair,
            'student_name' => $data->student_name,
            'teacher_name' => $data->teacher_name,
            'question' => $data->question,
            'answer' => $data->answer,
            'date_answer'   => $data->date_answer,
            'date_question'   => $data->date_question,
        ];

        $output = $output === false ? [] : $output;
        
        return $output;
    }

    public static function getTestsDetails($elementID){
        $output = [];
        $data = DB::table('answers as a')
            ->join('teachers as t', 't.employees_id', '=', 'a.teacher_id')
            ->join('student_questions as sq', 'a.question_id', '=', 'sq.id')
            ->join('users as student_u', 'student_u.id', '=', 'sq.student_id')
            ->join('users as teacher_u', 'teacher_u.id', '=', 't.employees_id')
            ->where('a.id', '=', $elementID)
            ->select([
                'sq.affair as affair',
                'student_u.name as student_name',
                'teacher_u.name as teacher_name',
                'sq.menssage as question',
                'a.menssage as answer',
                'a.date_sent as date_answer',
                'sq.date_sent as date_question'
            ])
            ->first();

        $output = [
            'affair' => $data->affair,
            'student_name' => $data->student_name,
            'teacher_name' => $data->teacher_name,
            'question' => $data->question,
            'answer' => $data->answer,
            'date_answer'   => $data->date_answer,
            'date_question'   => $data->date_question,
        ];

        $output = $output === false ? [] : $output;
        
        return $output;
    }
}