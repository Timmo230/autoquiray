<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentSettingsController extends Controller
{
    public function show(Request $request)
    {
        $studentId = Auth::id();
        $user = Auth::user();
        $activeTab = $this->normalizeTab($request->query('tab', 'profile'));

        $tuitionStatuses = [
            'pendientePago' => 'Pendiente de pago',
            'matriculado' => 'Matriculado',
            'expirado' => 'Expirado',
            'finalizado' => 'Finalizado',
        ];

        $tuitions = DB::table('tutions as tu')
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

        $activePermissionIds = $tuitions
            ->filter(fn ($tuition) => $tuition->is_active)
            ->pluck('permission_id')
            ->unique()
            ->values();

        $examTypeLabels = [
            'theorist' => 'Teórico',
            'practical' => 'Práctico',
        ];

        $exams = DB::table('exams as e')
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
                $examDateTime = \Carbon\Carbon::parse($exam->date . ' ' . $exam->start_time);
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

        $recentTests = DB::table('student_completes_tests as sct')
            ->join('tests as t', 't.id', '=', 'sct.test_id')
            ->where('sct.student_id', $studentId)
            ->orderByDesc('sct.updated_at')
            ->limit(5)
            ->select('t.title', 't.type', 'sct.last_note', 't.max_note', 'sct.time', 'sct.updated_at')
            ->get();

        $recentClasses = DB::table('students_reserves_classes as src')
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

        $recentQuestions = DB::table('student_questions as sq')
            ->leftJoin('answers as a', 'a.question_id', '=', 'sq.id')
            ->where('sq.student_id', $studentId)
            ->groupBy('sq.id', 'sq.affair', 'sq.date_sent', 'sq.menssage')
            ->orderByDesc('sq.date_sent')
            ->limit(5)
            ->select(
                'sq.affair',
                'sq.date_sent',
                'sq.menssage',
                DB::raw('COUNT(a.id) as answers_count')
            )
            ->get();

        $stats = [
            'active_tuitions' => $tuitions->filter(fn ($tuition) => $tuition->is_active)->count(),
            'registered_exams' => $exams->filter(fn ($exam) => $exam->is_registered && ! $exam->is_past)->count(),
            'completed_tests' => DB::table('student_completes_tests')->where('student_id', $studentId)->count(),
            'reserved_classes' => DB::table('students_reserves_classes')->where('student_id', $studentId)->count(),
        ];

        return view('student.settings', [
            'activeTab' => $activeTab,
            'user' => $user,
            'tuitions' => $tuitions,
            'exams' => $exams,
            'recentTests' => $recentTests,
            'recentClasses' => $recentClasses,
            'recentQuestions' => $recentQuestions,
            'stats' => $stats,
        ]);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id() . ',id',
            'document_type' => 'required|in:DNI,passport',
            'document_id' => 'required|string|max:255',
        ]);

        DB::table('users')
            ->where('id', Auth::id())
            ->update([
                'name' => trim((string) $request->input('name')),
                'email' => trim((string) $request->input('email')),
                'document_type' => $request->input('document_type'),
                'document_id' => trim((string) $request->input('document_id')),
                'updated_at' => now(),
            ]);

        return redirect()
            ->route('student.settings', ['tab' => 'profile'])
            ->with('success', 'Tus datos personales se han actualizado.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (! $user->password || ! Hash::check($request->input('current_password'), $user->password)) {
            return redirect()
                ->route('student.settings', ['tab' => 'security'])
                ->withErrors(['current_password' => 'La contraseña actual no es correcta.']);
        }

        DB::table('users')
            ->where('id', $user->id)
            ->update([
                'password' => Hash::make($request->input('password')),
                'updated_at' => now(),
            ]);

        return redirect()
            ->route('student.settings', ['tab' => 'security'])
            ->with('success', 'La contraseña se ha actualizado correctamente.');
    }

    public function registerExam(string $examId)
    {
        $studentId = Auth::id();

        $exam = DB::table('exams')
            ->where('id', $examId)
            ->first();

        if (! $exam) {
            return redirect()
                ->route('student.settings', ['tab' => 'exams'])
                ->with('error', 'El examen solicitado no existe.');
        }

        $alreadyRegistered = DB::table('registers')
            ->where('student_id', $studentId)
            ->where('exam_id', $examId)
            ->exists();

        if ($alreadyRegistered) {
            return redirect()
                ->route('student.settings', ['tab' => 'exams'])
                ->with('error', 'Ya estás inscrito en este examen.');
        }

        if (\Carbon\Carbon::parse($exam->date . ' ' . $exam->start_time)->isPast()) {
            return redirect()
                ->route('student.settings', ['tab' => 'exams'])
                ->with('error', 'No puedes apuntarte a un examen que ya ha empezado.');
        }

        $hasActiveTuition = DB::table('tutions')
            ->where('student_id', $studentId)
            ->where('permission_id', $exam->permission_id)
            ->whereIn('status', ['matriculado', 'pendientePago'])
            ->whereDate('max_end_date', '>=', now()->toDateString())
            ->exists();

        if (! $hasActiveTuition) {
            return redirect()
                ->route('student.settings', ['tab' => 'exams'])
                ->with('error', 'Necesitas una matrícula activa de ese permiso para inscribirte.');
        }

        DB::table('registers')->insert([
            'student_id' => $studentId,
            'exam_id' => $examId,
            'note' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('student.settings', ['tab' => 'exams'])
            ->with('success', 'Te has inscrito correctamente en el examen.');
    }

    protected function normalizeTab(string $tab): string
    {
        $allowedTabs = ['profile', 'tuitions', 'exams', 'security', 'activity'];

        return in_array($tab, $allowedTabs, true) ? $tab : 'profile';
    }
}
