<?php

namespace Tests\Feature\Controllers\GolfBallController;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class StoreGolfBallControllerTest extends TestCase
{
    public function test_it_stores_a_golfball(): void
    {
        $user = User::factory()->create();
        $make = 'Titleist';
        $model = 'AVX';

        $response = $this->actingAs($user)
            ->postJson(
                route('golfballs.store'),
                [
                    'make' => $make,
                    'model' => $model,
                ]
            )->assertCreated();

        $response
            ->assertJson(fn (AssertableJson $json) => $json->where('user_id', $user->id)
                ->where('make', $make)
                ->where('model', $model)
                ->etc()
            );
    }

    public function test_it_associates_the_golfball_with_the_requesting_user(): void
    {
        $user = User::factory()->create();
        $this->assertDatabaseCount('golf_balls', 0);

        $this->actingAs($user)
            ->postJson(
                route('golfballs.store'),
                [
                    'make' => 'Titleist',
                    'model' => 'AVX',
                ]
            )->assertCreated();

        $this->assertDatabaseCount('golf_balls', 1);
        $this->assertDatabaseHas('golf_balls', ['user_id' => $user->id]);
    }

    public function test_it_does_not_allow_guest_access(): void
    {
        $this->postJson(
            route('golfballs.store'),
            [
                'make' => 'Titleist',
                'model' => 'AVX',
            ]
        )->assertUnauthorized();
    }

    public function test_it_returns_a_json_resource_on_successful_store_requests(): void
    {
        $user = User::factory()->create();
        $make = 'Titleist';
        $model = 'AVX';

        $response = $this->actingAs($user)
            ->postJson(
                route('golfballs.store'),
                [
                    'make' => $make,
                    'model' => $model,
                ]
            )->assertCreated();

        $response
            ->assertJson(fn (AssertableJson $json) => $json->where('user_id', $user->id)
                ->where('make', $make)
                ->where('model', $model)
                ->etc()
            );
    }
}
