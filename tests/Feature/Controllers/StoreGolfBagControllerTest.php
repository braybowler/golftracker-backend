<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreGolfBagControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_stores_a_golfbag(): void
    {
        $user = User::factory()->create();

        $this->assertDatabaseCount('golf_bags', 0);

        $this->actingAs($user)
                ->postJson(
                    route('golfbags.store'),
                    [
                        'make' =>  'Test Bag',
                        'model' => 'Test Model',
                        'nickname' => 'Test Nickname',
                    ]
                )->assertOk();

        $this->assertDatabaseCount('golf_bags', 1);
    }

    public function test_it_associates_the_golfbag_with_the_requesting_user(): void
    {
        $user = User::factory()->create();

        $this->assertDatabaseCount('golf_bags', 0);

        $this->actingAs($user)
            ->postJson(
                route('golfbags.store'),
                [
                    'make' =>  'Test Bag',
                    'model' => 'Test Model',
                    'nickname' => 'Test Nickname',
                ]
            )->assertOk();

        $this->assertDatabaseCount('golf_bags', 1);
        $this->assertDatabaseHas('golf_bags', [
            'user_id' =>$user->id,
        ]);
    }

    public function test_it_does_not_allow_guest_access(): void
    {
        $this->postJson(
            route('golfbags.store'),
            [
                'make' =>  'Test Bag',
                'model' => 'Test Model',
                'nickname' => 'Test Nickname',
            ]
        )->assertUnauthorized();
    }

    public function test_it_returns_a_json_resource_on_successful_store_requests(): void
    {
        $user = User::factory()->create();
        $make = 'Test Bag';
        $model = 'Test Model';
        $nickname = 'Test Nickname';

        $response = $this->actingAs($user)
            ->postJson(
                route('golfbags.store'),
                [
                    'make' =>  $make,
                    'model' => $model,
                    'nickname' => $nickname,
                ]
            )->assertCreated();

        $response->dump();

        $response
            ->assertJson(fn (AssertableJson $json) =>
                $json->where('user_id', $user->id)
                     ->where('make', $make)
                     ->where('model', $model)
                     ->where('nickname', $nickname)
                     ->etc()
            );
    }
}
