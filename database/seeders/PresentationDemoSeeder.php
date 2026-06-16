<?php

namespace Database\Seeders;

use Database\Seeders\Support\RealisticSeedCatalog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PresentationDemoSeeder extends Seeder
{
    public function run(): void
    {
        $rootId = DB::table('users')->where('email', 'root@root.com')->value('id');

        if (! $rootId) {
            return;
        }

        $permissionIds = DB::table('permissions')->pluck('id', 'permission');
        $teacherIds = DB::table('teachers')
            ->where('employees_id', '!=', $rootId)
            ->pluck('employees_id')
            ->values();
        $studentIds = DB::table('students')
            ->where('user_id', '!=', $rootId)
            ->pluck('user_id')
            ->values();

        $this->createRootTuitions($rootId, $permissionIds->all());
        $rootTimetableIds = $this->createRootTimetables($rootId);
        $this->createRootClasses($rootId, $rootTimetableIds, $permissionIds->all());
        $this->createRootTests($rootId, $permissionIds->all());
        $this->createRootTeacherAnswers($rootId, $studentIds->all());
        $this->createRootStudentQuestions($rootId, $teacherIds->all());
        $this->createRootStudentCompletions($rootId);
        $this->createRootReservations($rootId);
        $this->createRootExamRegistrations($rootId);
    }

    protected function createRootTuitions(string $rootId, array $permissionIds): void
    {
        foreach (['B', 'A2', 'AM', 'C1'] as $index => $permissionCode) {
            $permissionId = $permissionIds[$permissionCode] ?? null;

            if (! $permissionId) {
                continue;
            }

            DB::table('tutions')->updateOrInsert(
                [
                    'student_id' => $rootId,
                    'permission_id' => $permissionId,
                ],
                [
                    'administrator_id' => $rootId,
                    'date' => now()->subDays(30 - ($index * 5))->toDateString(),
                    'start_date' => now()->subDays(20 - ($index * 5))->toDateString(),
                    'max_end_date' => now()->addMonths(8 - $index)->toDateString(),
                    'status' => $index === 3 ? 'finalizado' : 'matriculado',
                    'price' => [239.00, 269.00, 189.00, 359.00][$index],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }

    protected function createRootTimetables(string $rootId): array
    {
        $ids = [];

        for ($day = -8; $day <= 18; $day++) {
            $date = now()->addDays($day)->toDateString();
            foreach ([['09:00:00', '10:30:00'], ['17:00:00', '18:30:00']] as $slot) {
                $existingId = DB::table('timetables')
                    ->where('administrator_id', $rootId)
                    ->whereDate('date', $date)
                    ->where('start_time', $slot[0])
                    ->value('id');

                if ($existingId) {
                    $ids[] = $existingId;
                    continue;
                }

                $id = DB::table('timetables')->insertGetId([
                    'administrator_id' => $rootId,
                    'date' => $date,
                    'start_time' => $slot[0],
                    'end_time' => $slot[1],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $ids[] = $id;
            }
        }

        return $ids;
    }

    protected function createRootClasses(string $rootId, array $timetableIds, array $permissionIds): void
    {
        $titles = RealisticSeedCatalog::classTitles();

        foreach ($timetableIds as $index => $timetableId) {
            $title = $titles[$index % count($titles)] . ' - Grupo Root ' . floor($index / count($titles) + 1);

            $classId = DB::table('classes')->insertGetId([
                'teacher_id' => $rootId,
                'timetable_id' => $timetableId,
                'title' => $title,
                'max_students' => 18 + ($index % 7),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach (array_slice(array_values($permissionIds), $index % max(1, count($permissionIds)), 2) as $permissionId) {
                DB::table('permissions_are_tought_in_classes')->updateOrInsert(
                    ['class_id' => $classId, 'permission_id' => $permissionId],
                    ['created_at' => now(), 'updated_at' => now()]
                );
            }
        }
    }

    protected function createRootTests(string $rootId, array $permissionIds): void
    {
        $definitions = RealisticSeedCatalog::testDefinitions();
        $questionBank = RealisticSeedCatalog::questionBank();

        for ($index = 0; $index < 12; $index++) {
            $definition = $definitions[$index % count($definitions)];
            $testId = (string) Str::uuid();
            $title = $definition['title'] . ' - Demo Root ' . ($index + 1);

            DB::table('tests')->insert([
                'id' => $testId,
                'teacher_id' => $rootId,
                'title' => $title,
                'max_note' => $definition['question_count'],
                'max_time' => $definition['question_count'],
                'type' => $definition['type'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ([$definition['permission'], 'B'] as $permissionCode) {
                $permissionId = $permissionIds[$permissionCode] ?? null;
                if (! $permissionId) {
                    continue;
                }

                DB::table('permissions_are_associated_test')->updateOrInsert(
                    ['test_id' => $testId, 'permission_id' => $permissionId],
                    ['created_at' => now(), 'updated_at' => now()]
                );
            }

            $questions = $questionBank[$definition['type']] ?? $questionBank['dgt'];

            for ($questionIndex = 0; $questionIndex < $definition['question_count']; $questionIndex++) {
                $template = $questions[$questionIndex % count($questions)];
                $questionId = (string) Str::uuid();

                DB::table('question_tests')->insert([
                    'id' => $questionId,
                    'test_id' => $testId,
                    'teacher_id' => $rootId,
                    'title' => $template['title'],
                    'correct_option_id' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $optionIds = [];
                foreach ($template['options'] as $optionText) {
                    $optionId = (string) Str::uuid();
                    $optionIds[] = $optionId;

                    DB::table('options')->insert([
                        'id' => $optionId,
                        'question_id' => $questionId,
                        'option' => $optionText,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                DB::table('question_tests')
                    ->where('id', $questionId)
                    ->update([
                        'correct_option_id' => $optionIds[$template['correct']],
                        'updated_at' => now(),
                    ]);
            }
        }
    }

    protected function createRootTeacherAnswers(string $rootId, array $studentIds): void
    {
        $subjects = RealisticSeedCatalog::studentQuestionSubjects();
        $messages = RealisticSeedCatalog::studentQuestionMessages();
        $answers = RealisticSeedCatalog::teacherAnswerMessages();

        foreach (range(0, 39) as $index) {
            $studentId = $studentIds[$index % count($studentIds)] ?? null;

            if (! $studentId) {
                continue;
            }

            $questionId = (string) Str::uuid();

            DB::table('student_questions')->insert([
                'id' => $questionId,
                'student_id' => $studentId,
                'message' => $messages[$index % count($messages)],
                'date_sent' => now()->subDays(20 - ($index % 20))->subMinutes($index * 7),
                'affair' => $subjects[$index % count($subjects)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach (range(0, 1) as $replyIndex) {
                DB::table('answers')->insert([
                    'id' => (string) Str::uuid(),
                    'teacher_id' => $rootId,
                    'question_id' => $questionId,
                    'message' => $answers[($index + $replyIndex) % count($answers)],
                    'date_sent' => now()->subDays(19 - ($index % 19))->subMinutes($index * 5 + $replyIndex),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    protected function createRootStudentQuestions(string $rootId, array $teacherIds): void
    {
        $subjects = RealisticSeedCatalog::studentQuestionSubjects();
        $messages = RealisticSeedCatalog::studentQuestionMessages();
        $answers = RealisticSeedCatalog::teacherAnswerMessages();

        foreach (range(0, 9) as $index) {
            $questionId = (string) Str::uuid();

            DB::table('student_questions')->insert([
                'id' => $questionId,
                'student_id' => $rootId,
                'message' => $messages[$index % count($messages)],
                'date_sent' => now()->subDays($index)->subHours(2),
                'affair' => $subjects[$index % count($subjects)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if (! empty($teacherIds)) {
                DB::table('answers')->insert([
                    'id' => (string) Str::uuid(),
                    'teacher_id' => $teacherIds[$index % count($teacherIds)],
                    'question_id' => $questionId,
                    'message' => $answers[$index % count($answers)],
                    'date_sent' => now()->subDays($index)->subHour(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    protected function createRootStudentCompletions(string $rootId): void
    {
        $tests = DB::table('tests')
            ->orderByDesc('created_at')
            ->limit(24)
            ->get(['id', 'max_time', 'max_note']);

        foreach ($tests as $index => $test) {
            DB::table('student_completes_tests')->updateOrInsert(
                [
                    'student_id' => $rootId,
                    'test_id' => $test->id,
                ],
                [
                    'last_note' => $test->max_note >= 27
                        ? max(24, $test->max_note - ($index % 4))
                        : max(7, $test->max_note - ($index % 3)),
                    'time' => max(120, ($test->max_time * 60) - ($index * 11)),
                    'created_at' => now()->subDays($index % 12),
                    'updated_at' => now()->subDays($index % 12),
                ]
            );
        }
    }

    protected function createRootReservations(string $rootId): void
    {
        $classIds = DB::table('classes as c')
            ->join('timetables as tm', 'tm.id', '=', 'c.timetable_id')
            ->whereDate('tm.date', '>=', now()->toDateString())
            ->orderBy('tm.date')
            ->orderBy('tm.start_time')
            ->limit(18)
            ->pluck('c.id');

        foreach ($classIds as $index => $classId) {
            DB::table('students_reserves_classes')->updateOrInsert(
                [
                    'student_id' => $rootId,
                    'class_id' => $classId,
                ],
                [
                    'created_at' => now()->subDays($index % 6),
                    'updated_at' => now()->subDays($index % 6),
                ]
            );
        }
    }

    protected function createRootExamRegistrations(string $rootId): void
    {
        $exams = DB::table('exams')
            ->orderBy('date')
            ->orderBy('start_time')
            ->limit(16)
            ->get(['id']);

        foreach ($exams as $index => $exam) {
            DB::table('registers')->updateOrInsert(
                [
                    'student_id' => $rootId,
                    'exam_id' => $exam->id,
                ],
                [
                    'note' => $index < 4 ? 27 + ($index % 3) : null,
                    'created_at' => now()->subDays($index % 9),
                    'updated_at' => now()->subDays($index % 9),
                ]
            );
        }
    }
}
