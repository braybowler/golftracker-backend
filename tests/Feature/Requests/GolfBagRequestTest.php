<?php

namespace Tests\Feature\Requests;

use App\Models\User;
use Tests\TestCase;
class GolfBagRequestTest extends TestCase
{
    public function test_it_validates_the_make_attribute_of_a_golfbag_request_is_required()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson(
                route('golfbags.store'),
                [
                    'make' => '',
                    'model' => 'Test String',
                    'nickname' => 'Test Nickname',
                ]
            )->assertUnprocessable();
    }

    public function test_it_validates_the_make_attribute_of_a_golfbag_request_must_be_a_string()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson(
                route('golfbags.store'),
                [
                    'make' => 1,
                    'model' => 'Test String',
                    'nickname' => 'Test Nickname',
                ]
            )->assertUnprocessable();
    }

    public function test_it_validates_the_model_attribute_of_a_golfbag_request_is_required()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson(
                route('golfbags.store'),
                [
                    'make' => 'Test Make',
                    'model' => '',
                    'nickname' => 'Test Nickname',
                ]
            )->assertUnprocessable();
    }

    public function test_it_validates_the_model_attribute_of_a_golfbag_request_must_be_a_string()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson(
                route('golfbags.store'),
                [
                    'make' => 'Test Make',
                    'model' => 1,
                    'nickname' => 'Test Nickname',
                ]
            )->assertUnprocessable();
    }

    public function test_the_nickname_attribute_of_a_golfbag_request_is_not_required()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson(
                route('golfbags.store'),
                [
                    'make' => 'Test Make',
                    'model' => 'Test Model',
                    'nickname' => '',
                ]
            )->assertCreated();
    }

    public function test_it_validates_that_the_nickname_attribute_of_a_golfbag_request_must_be_a_string_if_its_present()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson(
                route('golfbags.store'),
                [
                    'make' => 'Test Make',
                    'model' => 'Test Model',
                    'nickname' => 1,
                ]
            )->assertUnprocessable();
    }
}
