<?php

namespace Tests\Feature\Controllers\AuthController;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogoutAuthControllerTest extends TestCase
{
    public function test_it_allows_an_authenticated_user_to_logout()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'name' => 'John Doe',
            'password' => 'password',
        ]);

        $this->actingAs($user)
            ->postJson(route('auth.logout'))->assertNoContent();
    }

    public function test_it_does_not_allow_guest_access()
    {
        $this->postJson(route('auth.logout'))->assertUnauthorized();
    }
}
