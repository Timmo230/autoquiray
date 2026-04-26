<?php

namespace App\Http\Controllers;

use App\Services\StudentSettingsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentSettingsController extends Controller
{
    public function __construct(
        protected StudentSettingsService $studentSettingsService
    ) {
    }

    public function show(Request $request)
    {
        $studentId = Auth::id();
        $user = Auth::user();
        $activeTab = $this->normalizeTab($request->query('tab', 'profile'));

        return view('student.settings', $this->studentSettingsService->buildViewData($studentId, $activeTab, $user));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id() . ',id',
            'document_type' => 'required|in:DNI,passport',
            'document_id' => 'required|string|max:255',
        ]);

        \DB::table('users')
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

        \DB::table('users')
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
        $result = $this->studentSettingsService->registerStudentForExam($studentId, $examId);

        return redirect()
            ->route('student.settings', ['tab' => 'exams'])
            ->with($result['status'], $result['message']);
    }

    protected function normalizeTab(string $tab): string
    {
        $allowedTabs = ['profile', 'tuitions', 'exams', 'security', 'activity'];

        return in_array($tab, $allowedTabs, true) ? $tab : 'profile';
    }
}
