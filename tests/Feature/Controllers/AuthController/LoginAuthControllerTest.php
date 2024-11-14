<?php

namespace Tests\Feature\Controllers\AuthController;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginAuthControllerTest extends TestCase
{
    public function test_it_allows_a_registered_user_to_login()
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'name' => 'John Doe',
            'password' => 'password',
        ]);

        $this->postJson(route('auth.login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]))->assertOk();
    }

    public function test_it_disallows_a_user_from_logging_in_with_incorrect_credentials()
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'name' => 'John Doe',
            'password' => 'password',
        ]);

        $this->postJson(route('auth.login', [
            'email' => 'different@example.com',
            'password' => 'password',
        ]))->assertNotFound();
    }

    public function test_it_authenticates_the_user_automatically_after_login()
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'name' => 'John Doe',
            'password' => 'password',
        ]);

        $this->postJson(route('auth.login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]))->assertok();

        $this->assertAuthenticatedAs(User::first());
    }
}
