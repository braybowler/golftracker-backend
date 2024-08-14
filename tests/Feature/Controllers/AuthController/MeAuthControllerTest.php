<?php

namespace Tests\Feature\Controllers\AuthController;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MeAuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_the_authed_user_if_a_user_is_in_the_auth_session()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'name' => 'John Doe',
            'password' => 'password',
        ]);

        $this->actingAs($user)->getJson(route('auth.me'))->assertOk();
    }

    public function test_it_disallows_guest_access()
    {
        $this->getJson(route('auth.me'))->assertUnauthorized();
    }

}
