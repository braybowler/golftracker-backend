<?php

namespace Tests\Feature\Controllers\AuthController;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegisterAuthControllerTest extends TestCase
{
    public function test_it_allows_a_new_user_to_register()
    {
        $this->assertDatabaseCount('users', 0);

        $this->postJson(route('auth.register', [
            'email' => 'test@example.com',
            'name' => 'John Doe',
            'password' => 'password',
        ]))->assertCreated();

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'name' => 'John Doe',
        ]);

        //TODO: (d/w Jacob) Better way to test against hashed values?
        $this->assertTrue(
            Hash::check('password', User::first()->password),
        );
    }

    public function test_it_disallows_a_new_user_from_registering_with_a_non_unique_email()
    {
        $this->assertDatabaseCount('users', 0);

        $this->postJson(route('auth.register', [
            'email' => 'test@example.com',
            'name' => 'John Doe',
            'password' => 'password',
        ]))->assertCreated();

        $this->postJson(route('auth.register', [
            'email' => 'test@example.com',
            'name' => 'Jane Doe',
            'password' => 'password',
        ]))->assertUnprocessable(); //TODO: (d/w Jacob) is this the right response code?

        $this->assertDatabaseCount('users', 1);
    }

    public function test_it_authenticates_the_user_automatically_after_registration()
    {
        $this->postJson(route('auth.register', [
            'email' => 'test@example.com',
            'name' => 'John Doe',
            'password' => 'password',
        ]))->assertCreated();

        $this->assertAuthenticatedAs(User::first());
    }
}
