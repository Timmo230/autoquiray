<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StudentSettingsService
{
    public function buildViewData(string $studentId, string $activeTab, object $user): array
    {
        $tuitions = $this->getTuitions($studentId);
        $activePermissionIds = $tuitions
            ->filter(fn ($tuition) => $tuition->is_active)
            ->pluck('permission_id')
            ->unique()
            ->values();

        $exams = $this->getExams($studentId, $activePermissionIds);

        return [
            'activeTab' => $activeTab,
            'user' => $user,
            'tuitions' => $tuitions,
            'exams' => $exams,
            'recentTests' => $this->getRecentTests($studentId),
            'recentClasses' => $this->getRecentClasses($studentId),
            'recentQuestions' => $this->getRecentQuestions($studentId),
            'stats' => $this->getStats($studentId, $tuitions, $exams),
        ];
    }

    public function registerStudentForExam(string $studentId, string $examId): array
    {
        $exam = DB::table('exams')
            ->where('id', $examId)
            ->first();

        if (! $exam) {
            return ['status' => 'error', 'message' => 'El examen solicitado no existe.'];
        }

        $alreadyRegistered = DB::table('registers')
            ->where('student_id', $studentId)
            ->where('exam_id', $examId)
            ->exists();

        if ($alreadyRegistered) {
            return ['status' => 'error', 'message' => 'Ya estás inscrito en este examen.'];
        }

        if (Carbon::parse($exam->date . ' ' . $exam->start_time)->isPast()) {
            return ['status' => 'error', 'message' => 'No puedes apuntarte a un examen que ya ha empezado.'];
        }

        $hasActiveTuition = DB::table('tutions')
            ->where('student_id', $studentId)
            ->where('permission_id', $exam->permission_id)
            ->whereIn('status', ['matriculado', 'pendientePago'])
            ->whereDate('max_end_date', '>=', now()->toDateString())
            ->exists();

        if (! $hasActiveTuition) {
            return ['status' => 'error', 'message' => 'Necesitas una matrícula activa de ese permiso para inscribirte.'];
        }

        DB::table('registers')->insert([
            'student_id' => $studentId,
            'exam_id' => $examId,
            'note' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return ['status' => 'success', 'message' => 'Te has inscrito correctamente en el examen.'];
    }

    protected function getTuitions(string $studentId)
    {
        $tuitionStatuses = [
            'pendientePago' => 'Pendiente de pago',
            'matriculado' => 'Matriculado',
            'expirado' => 'Expirado',
            'finalizado' => 'Finalizado',
        ];

        return DB::table('tutions as tu')
            ->join('permissions as p', 'p.id', '=', 'tu.permission_id')
            ->leftJoin('users as admin_u', 'admin_u.id', '=', 'tu.administrator_id')
            ->where('tu.student_id', $studentId)
            ->orderByDesc('tu.start_date')
            ->select(
                'tu.id',
                'tu.permission_id',
                'tu.date',
                'tu.start_date',
                'tu.max_end_date',
                'tu.status',
                'tu.price',
                'p.permission as permission_name',
                'admin_u.name as administrator_name'
            )
            ->get()
            ->map(function ($tuition) use ($tuitionStatuses) {
                $tuition->status_label = $tuitionStatuses[$tuition->status] ?? ucfirst((string) $tuition->status);
                $tuition->is_active = in_array($tuition->status, ['matriculado', 'pendientePago'], true)
                    && now()->toDateString() <= $tuition->max_end_date;

                return $tuition;
            });
    }

    protected function getExams(string $studentId, $activePermissionIds)
    {
        $examTypeLabels = [
            'theorist' => 'Teórico',
            'practical' => 'Práctico',
        ];

        return DB::table('exams as e')
            ->join('permissions as p', 'p.id', '=', 'e.permission_id')
            ->leftJoin('registers as r', function ($join) use ($studentId) {
                $join->on('r.exam_id', '=', 'e.id')
                    ->where('r.student_id', '=', $studentId);
            })
            ->orderBy('e.date')
            ->orderBy('e.start_time')
            ->select(
                'e.id',
                'e.permission_id',
                'e.date',
                'e.start_time',
                'e.type',
                'e.price',
                'p.permission as permission_name',
                'r.note as note',
                DB::raw('CASE WHEN r.exam_id IS NULL THEN 0 ELSE 1 END as is_registered')
            )
            ->get()
            ->map(function ($exam) use ($activePermissionIds, $examTypeLabels) {
                $examDateTime = Carbon::parse($exam->date . ' ' . $exam->start_time);
                $exam->type_label = $examTypeLabels[$exam->type] ?? ucfirst((string) $exam->type);
                $exam->is_registered = (bool) $exam->is_registered;
                $exam->can_register = ! $exam->is_registered
                    && $examDateTime->isFuture()
                    && $activePermissionIds->contains($exam->permission_id);
                $exam->is_past = $examDateTime->isPast();
                $exam->status_label = $exam->is_registered
                    ? ($exam->note === null ? 'Inscrito' : 'Calificado')
                    : ($exam->can_register ? 'Disponible' : 'No disponible');

                return $exam;
            });
    }

    protected function getRecentTests(string $studentId)
    {
        return DB::table('student_completes_tests as sct')
            ->join('tests as t', 't.id', '=', 'sct.test_id')
            ->where('sct.student_id', $studentId)
            ->orderByDesc('sct.updated_at')
            ->limit(5)
            ->select('t.title', 't.type', 'sct.last_note', 't.max_note', 'sct.time', 'sct.updated_at')
            ->get();
    }

    protected function getRecentClasses(string $studentId)
    {
        return DB::table('students_reserves_classes as src')
            ->join('classes as c', 'c.id', '=', 'src.class_id')
            ->join('timetables as tm', 'tm.id', '=', 'c.timetable_id')
            ->join('teachers as t', 't.employees_id', '=', 'c.teacher_id')
            ->join('users as teacher_u', 'teacher_u.id', '=', 't.employees_id')
            ->where('src.student_id', $studentId)
            ->orderByDesc('tm.date')
            ->orderByDesc('tm.start_time')
            ->limit(5)
            ->select(
                'c.title',
                'tm.date',
                'tm.start_time',
                'tm.end_time',
                'teacher_u.name as teacher_name'
            )
            ->get();
    }

    protected function getRecentQuestions(string $studentId)
    {
        return DB::table('student_questions as sq')
            ->leftJoin('answers as a', 'a.question_id', '=', 'sq.id')
            ->where('sq.student_id', $studentId)
            ->groupBy('sq.id', 'sq.affair', 'sq.date_sent', 'sq.message')
            ->orderByDesc('sq.date_sent')
            ->limit(5)
            ->select(
                'sq.affair',
                'sq.date_sent',
                'sq.message',
                DB::raw('COUNT(a.id) as answers_count')
            )
            ->get();
    }

    protected function getStats(string $studentId, $tuitions, $exams): array
    {
        return [
            'active_tuitions' => $tuitions->filter(fn ($tuition) => $tuition->is_active)->count(),
            'registered_exams' => $exams->filter(fn ($exam) => $exam->is_registered && ! $exam->is_past)->count(),
            'completed_tests' => DB::table('student_completes_tests')->where('student_id', $studentId)->count(),
            'reserved_classes' => DB::table('students_reserves_classes')->where('student_id', $studentId)->count(),
        ];
    }
}
