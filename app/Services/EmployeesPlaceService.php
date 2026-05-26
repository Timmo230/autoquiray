<?php

namespace App\Services;

use App\Support\LegacyMessageColumns;
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
        $answerMessageColumn = LegacyMessageColumns::answers();
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
                        'a.' . $answerMessageColumn . ' as answer',
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
        $studentQuestionMessageColumn = LegacyMessageColumns::studentQuestions();
        $answerMessageColumn = LegacyMessageColumns::answers();
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
                'sq.' . $studentQuestionMessageColumn . ' as question',
                'a.' . $answerMessageColumn . ' as answer',
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
        $data = DB::table('tests as t')
            ->leftJoin('permissions_are_associated_test as pat', 't.id', '=', 'pat.test_id')
            ->leftJoin('permissions as p', 'pat.permission_id', '=', 'p.id')
            ->leftJoin('student_completes_tests as sct', 't.id', '=', 'sct.test_id')
            ->leftJoin('question_tests as qt', 'qt.test_id', '=', 't.id')
            ->leftJoin('options as o', 'o.question_id', '=', 'qt.id')
            ->where('t.id', '=', $elementID)
            ->select([
                't.id as test_id',
                't.teacher_id as teacher_id',
                't.title as testTitle',
                't.type as testType',
                't.max_time as max_time',
                't.max_note as max_note',

                'p.id as permission_id',
                'p.permission as permission',

                'sct.student_id as student_id',

                'qt.id as question_id',
                'qt.title as questionTitle',
                'qt.correct_option_id as correct_option_id',

                'o.id as option_id',
                'o.option as option',
            ])
            ->get()
            ->toArray();

        $output = (object)[
            'teacherName' => self::getTeacherName($data[0]->teacher_id),
            'testTitle' => $data[0]->testTitle,
            'testType' => $data[0]->testType,
            'max_time' => $data[0]->max_time,
            'max_note' => $data[0]->max_note,
            'studentsCount' => 0,
            'permissions' => [],
            'questions' => [],
        ];

        $studentIds = [];
        $permissionIds = [];
        $questionsMap = [];

        foreach ($data as $row) {
            // Contar alumnos únicos
            if (!empty($row->student_id) && !in_array($row->student_id, $studentIds)) {
                $studentIds[] = $row->student_id;
            }

            // Guardar permisos únicos
            if (!empty($row->permission_id) && !isset($permissionIds[$row->permission_id])) {
                $permissionIds[$row->permission_id] = true;

                $output->permissions[] = $row->permission;
            }

            // Crear pregunta si no existe
            if (!empty($row->question_id) && !isset($questionsMap[$row->question_id])) {
                $questionsMap[$row->question_id] = (object)[
                    'id' => $row->question_id,
                    'questionTitle' => $row->questionTitle,
                    'correct_option_id' => $row->correct_option_id,
                    'options' => [],
                ];
            }

            // Añadir opción a la pregunta si no existe
            if (!empty($row->question_id) && !empty($row->option_id)) {
                $existsOption = false;

                foreach ($questionsMap[$row->question_id]->options as $opt) {
                    if ($opt->id === $row->option_id) {
                        $existsOption = true;
                        break;
                    }
                }

                if (!$existsOption) {
                    $questionsMap[$row->question_id]->options[] = (object)[
                        'id' => $row->option_id,
                        'option' => $row->option,
                        'is_correct' => $row->option_id === $row->correct_option_id,
                    ];
                }
            }
        }

        $output->studentsCount = count($studentIds);
        $output->questions = array_values($questionsMap);

        $output = $output === false ? [] : $output;
        
        return $output;
        /*
        Ejemplo de retorno
        (object) [
            'id' => 'test-uuid-123',
            'teacher_id' => 'teacher-uuid-45',
            'testTitle' => 'Test de circulación básica',
            'testType' => 'circulacion',
            'max_time' => 30,
            'max_note' => 10,

            'studentsCount' => 2,

            'permissions' => [
                'B',
                'A2',
                'AM'
            ],

            'questions' => [
                (object) [
                    'id' => 'q1',
                    'questionTitle' => '¿Qué indica esta señal?',
                    'correct_option_id' => 'op2',

                    'options' => [
                        (object) [
                            'id' => 'op1',
                            'option' => 'Ceda el paso',
                            'is_correct' => false
                        ],
                        (object) [
                            'id' => 'op2',
                            'option' => 'Stop',
                            'is_correct' => true
                        ],
                        (object) [
                            'id' => 'op3',
                            'option' => 'Prohibido',
                            'is_correct' => false
                        ]
                    ]
                ]
            ]
        ] */
    }


    public static function getClassesDetails($elementID){
        $output = [];

        $data = DB::table('classes as c')
                    ->leftJoin('teachers as t', 't.employees_id', '=', 'c.teacher_id')
                    ->leftJoin('timetables as tm', 'c.timetable_id', '=', 'tm.id')
                    ->leftJoin('permissions_are_tought_in_classes as ptc', 'c.id', '=', 'ptc.class_id')
                    ->leftJoin('permissions as p', 'p.id', '=', 'ptc.permission_id')
                    ->leftJoin('students_reserves_classes as src','src.class_id','=','c.id')
                    ->leftJoin('users as u', 'u.id', '=', 'src.student_id')
                    ->where('c.id', '=', $elementID)
                    ->select([
                        'c.id as id',
                        'c.title as title',
                        'c.max_students as max_students',
                        'tm.start_time as start_time',
                        'tm.end_time as end_time',
                        'tm.date as date',

                        'p.id as permission_id',
                        'p.permission as permission',

                        'src.student_id as student_id',
                        'u.name as student_name',

                        't.employees_id as teacher_id'
                    ])
                    ->get()
                    ->toArray();
        
        $output = (object)[
            'teacherName' => self::getTeacherName($data[0]->teacher_id),
            'title' => $data[0]->title,
            'date' => $data[0]->date,
            'start_time' => $data[0]->start_time,
            'end_time' => $data[0]->end_time,
            'max_students' => $data[0]->max_students,
            'permissions' => [],
            'students' => [],
            'done' => $data[0]->date < now() ? false : true,
        ];

        $studentIds = [];
        $permissionIds = [];

        foreach ($data as $row) {
            // Contar alumnos únicos
            if (!empty($row->student_id) && !in_array($row->student_id, $studentIds)) {
                $studentIds[] = $row->student_id;
                $output->students[] = $row->student_name;;
            }

            // Guardar permisos únicos
            if (!empty($row->permission_id) && !isset($permissionIds[$row->permission_id])) {
                $permissionIds[$row->permission_id] = true;

                $output->permissions[] = $row->permission;
            }
        }

        $output = $output === false ? [] : $output;
        
        return $output;
    }

    public static function getTeacherName($teacherID){
        return DB::table('users')
                ->where('id', $teacherID)
                ->pluck('name')
                ->first();
    }
}
