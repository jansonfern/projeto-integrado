<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AuthFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'password' => 'password',
            'role' => 'paciente',
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_can_request_password_reset_link(): void
    {
        Notification::fake();

        $user = User::factory()->create(['role' => 'paciente']);

        $response = $this->post('/forgot-password', [
            'email' => $user->email,
        ]);

        $response->assertSessionHas('status');
    }
}
