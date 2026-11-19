<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_open_login_and_registration_pages(): void
    {
        $this->withoutVite()
            ->get(route('login'))
            ->assertOk()
            ->assertSee('Welcome back')
            ->assertSee('Create an account');

        $this->get(route('register'))
            ->assertOk()
            ->assertSee('Create your account')
            ->assertSee('Confirm password');
    }

    public function test_registration_creates_a_hashed_account_and_logs_the_user_in(): void
    {
        $this->post(route('register.store'), [
            'name' => 'Taylor Rivera',
            'email' => 'TAYLOR@example.com',
            'password' => 'secure-pass-123',
            'password_confirmation' => 'secure-pass-123',
        ])->assertRedirect(route('events.index'));

        $user = User::where('email', 'taylor@example.com')->firstOrFail();

        $this->assertAuthenticatedAs($user);
        $this->assertTrue(password_verify('secure-pass-123', $user->password));
    }

    public function test_user_can_log_in_and_logout(): void
    {
        $user = User::factory()->create([
            'email' => 'member@example.com',
            'password' => 'secure-pass-123',
        ]);

        $this->post(route('login.store'), [
            'email' => 'MEMBER@example.com',
            'password' => 'secure-pass-123',
        ])->assertRedirect(route('events.index'));

        $this->assertAuthenticatedAs($user);

        $this->post(route('logout'))
            ->assertRedirect(route('login'));

        $this->assertGuest();
        $this->get(route('events.index'))->assertRedirect(route('login'));
    }

    public function test_five_failed_logins_lock_out_further_attempts(): void
    {
        $user = User::factory()->create([
            'email' => 'member@example.com',
            'password' => 'secure-pass-123',
        ]);

        for ($attempt = 1; $attempt <= 5; $attempt++) {
            $this->from(route('login'))
                ->post(route('login.store'), [
                    'email' => $user->email,
                    'password' => 'incorrect-password',
                ])
                ->assertRedirect(route('login'))
                ->assertSessionHasErrors(['email']);
        }

        $this->from(route('login'))
            ->post(route('login.store'), [
                'email' => $user->email,
                'password' => 'secure-pass-123',
            ])
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors(['email']);

        $error = session('errors')->getBag('default')->first('email');
        $this->assertStringContainsString('Too many login attempts', $error);
    }

    public function test_authenticated_users_cannot_open_guest_pages_and_workspace_requires_authentication(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('login'))
            ->assertRedirect(route('home'));

        $this->get(route('register'))
            ->assertRedirect(route('home'));

        auth()->logout();

        $this->get(route('home'))->assertRedirect(route('login'));
        $this->get(route('events.index'))->assertRedirect(route('login'));
        $this->post(route('events.store'))->assertRedirect(route('login'));
    }
}
