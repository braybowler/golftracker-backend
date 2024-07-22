<?php

namespace Tests\Feature\Controllers\GolfClubController;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class StoreGolfClubControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_stores_a_golfclub(): void
    {
        $user = User::factory()->create();
        $make = 'Titleist';
        $model = 'MB';
        $loft = 46;
        $carryDistance = 130;
        $totalDistance = 130;

        $response = $this->actingAs($user)
            ->postJson(
                route('golfclubs.store'),
                [
                    'make' => $make,
                    'model' => $model,
                    'loft' => $loft,
                    'carry_distance' => $carryDistance,
                    'total_distance' => $totalDistance,
                ]
            )->assertCreated();

        $response
            ->assertJson(fn (AssertableJson $json) =>
                $json->where('user_id', $user->id)
                        ->where('make', $make)
                        ->where('model', $model)
                        ->where('loft', $loft)
                        ->where('carry_distance', $carryDistance)
                        ->where('total_distance', $totalDistance)
                        ->etc()
            );
    }

    public function test_it_associates_the_golfclub_with_the_requesting_user(): void
    {
        $user = User::factory()->create();
        $this->assertDatabaseCount('golf_clubs', 0);

        $this->actingAs($user)
            ->postJson(
                route('golfclubs.store'),
                [
                    'make' => 'Titleist',
                    'model' => 'MB',
                    'loft' => 46,
                    'carry_distance' => 130,
                    'total_distance' => 130,
                ]
            )->assertCreated();

        $this->assertDatabaseCount('golf_clubs', 1);
        $this->assertDatabaseHas('golf_clubs', ['user_id' => $user->id]);
    }

    public function test_it_does_not_allow_guest_access(): void
    {
        $this->postJson(
                route('golfclubs.store'),
                [
                    'make' => 'Titleist',
                    'model' => 'MB',
                    'loft' => 46,
                    'carry_distance' => 130,
                    'total_distance' => 130,
                ]
            )->assertUnauthorized();
    }

    public function test_it_returns_a_json_resource_on_successful_store_requests(): void
    {
        $user = User::factory()->create();
        $make = 'Titleist';
        $model = 'MB';
        $loft = 46;
        $carryDistance = 130;
        $totalDistance = 130;

        $response = $this->actingAs($user)
            ->postJson(
                route('golfclubs.store'),
                [
                    'make' => $make,
                    'model' => $model,
                    'loft' => $loft,
                    'carry_distance' => $carryDistance,
                    'total_distance' => $totalDistance,
                ]
            )->assertCreated();

        $response
            ->assertJson(fn (AssertableJson $json) =>
                $json->where('user_id', $user->id)
                        ->where('make', $make)
                        ->where('model', $model)
                        ->where('loft', $loft)
                        ->where('carry_distance', $carryDistance)
                        ->where('total_distance', $totalDistance)
                        ->etc()
            );
    }
}
