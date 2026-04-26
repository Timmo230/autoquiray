<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\Concerns\CreatesDomainData;
use Tests\TestCase;

class StudentExamRegistrationTest extends TestCase
{
    use CreatesDomainData;
    use RefreshDatabase;

    public function test_student_can_register_for_exam_with_active_tuition(): void
    {
        $student = $this->createStudentUser();
        $permissionId = $this->createPermission('B');
        $examId = $this->createExam($permissionId);
        $this->createTuition($student->id, $permissionId);

        $response = $this->actingAs($student)
            ->withSession(['active_role' => 'student'])
            ->post(route('student.settings.exams.register', $examId));

        $response->assertRedirect(route('student.settings', ['tab' => 'exams']));
        $response->assertSessionHas('success', 'Te has inscrito correctamente en el examen.');

        $this->assertDatabaseHas('registers', [
            'student_id' => $student->id,
            'exam_id' => $examId,
        ]);
    }

    public function test_student_cannot_register_for_exam_without_active_tuition(): void
    {
        $student = $this->createStudentUser();
        $permissionId = $this->createPermission('A2');
        $examId = $this->createExam($permissionId);

        $response = $this->actingAs($student)
            ->withSession(['active_role' => 'student'])
            ->post(route('student.settings.exams.register', $examId));

        $response->assertRedirect(route('student.settings', ['tab' => 'exams']));
        $response->assertSessionHas('error', 'Necesitas una matrícula activa de ese permiso para inscribirte.');

        $this->assertDatabaseMissing('registers', [
            'student_id' => $student->id,
            'exam_id' => $examId,
        ]);
    }
}
