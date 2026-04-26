<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\Concerns\CreatesDomainData;
use Tests\TestCase;

class AuthRoleFlowTest extends TestCase
{
    use CreatesDomainData;
    use RefreshDatabase;

    public function test_login_with_single_role_redirects_directly_to_role_area(): void
    {
        [$plainPassword, $hashedPassword] = $this->passwordForLogin();
        $user = $this->createUser([
            'email' => 'student@example.com',
            'password' => $hashedPassword,
        ]);

        $this->assignRole($user->id, 'student');

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $plainPassword,
        ]);

        $response->assertRedirect(route('student.testType'));
        $response->assertSessionHas('active_role', 'student');
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_with_multiple_roles_redirects_to_role_selection(): void
    {
        [$plainPassword, $hashedPassword] = $this->passwordForLogin();
        $user = $this->createUser([
            'email' => 'multi@example.com',
            'password' => $hashedPassword,
        ]);

        $this->assignRole($user->id, 'student');
        $this->assignRole($user->id, 'teacher');

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $plainPassword,
        ]);

        $response->assertRedirect(route('role.selection'));
        $response->assertSessionMissing('active_role');
        $response->assertSessionHas('available_roles', ['student', 'teacher']);
    }

    public function test_role_middleware_redirects_multi_role_user_without_active_role_to_selection(): void
    {
        $user = $this->createUser();
        $this->assignRole($user->id, 'student');
        $this->assignRole($user->id, 'teacher');

        $response = $this->actingAs($user)->get(route('student.testType'));

        $response->assertRedirect(route('role.selection'));
    }

    public function test_role_middleware_auto_assigns_single_role_when_session_is_missing(): void
    {
        $user = $this->createUser();
        $this->assignRole($user->id, 'student');

        $response = $this->actingAs($user)->get(route('student.testType'));

        $response->assertOk();
        $response->assertSessionHas('active_role', 'student');
    }

    public function test_change_password_endpoint_updates_user_hash(): void
    {
        $user = $this->createUser([
            'email' => 'password@example.com',
            'password' => Hash::make('old-password'),
        ]);

        $response = $this->postJson(route('changePassword'), [
            'email' => $user->email,
            'password' => 'new-password-456',
        ]);

        $response->assertOk()
            ->assertJson(['success' => true]);

        $this->assertTrue(
            Hash::check('new-password-456', DB::table('users')->where('id', $user->id)->value('password'))
        );
    }
}
