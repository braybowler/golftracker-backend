<?php

namespace Tests\Feature\Controllers\BaggableController;

use App\Models\GolfBall;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class StoreBaggableControllerTest extends TestCase
{
    public function test_it_stores_a_baggable(): void
    {
        $user = User::factory()->hasGolfBags()->hasGolfBalls()->create();
        $this->assertDatabaseCount('baggables', 0);

        $this->actingAs($user)
            ->postJson(
                route('baggables.store'),
                [
                    'bag' => [
                        'id' => $user->golfBags()->first()->id
                    ],
                    'baggable' => [
                        'id' => $user->golfBalls()->first()->id,
                        'type' => $user->golfBalls->first()->getMorphClass(),
                    ]
                ]
            )->assertCreated();

        $this->assertDatabaseCount('baggables', 1);
    }


    public function test_it_associates_the_baggable_with_the_bag(): void
    {
        $user = User::factory()->hasGolfBags()->hasGolfBalls()->create();
        $this->assertDatabaseCount('baggables', 0);

        $this->actingAs($user)
            ->postJson(
                route('baggables.store'),
                [
                    'bag' => [
                        'id' => $user->golfBags()->first()->id
                    ],
                    'baggable' => [
                        'id' => $user->golfBalls()->first()->id,
                        'type' => $user->golfBalls->first()->getMorphClass(),
                    ]
                ]
            )->assertCreated();

        $this->assertDatabaseCount('baggables', 1);
        $this->assertDatabaseHas('baggables', ['golf_bag_id' => $user->golfBags()->first()->id]);
    }

    public function test_it_does_not_allow_guest_access(): void
    {
        $this->postJson(
            route('baggables.store')
        )->assertUnauthorized();
    }

    public function test_it_returns_a_json_resource_on_successful_store_requests(): void
    {
        $user = User::factory()->hasGolfBags()->hasGolfBalls()->create();
        $this->assertDatabaseCount('baggables', 0);

        $response = $this->actingAs($user)
            ->postJson(
                route('baggables.store'),
                [
                    'bag' => [
                        'id' => $user->golfBags()->first()->id
                    ],
                    'baggable' => [
                        'id' => $user->golfBalls()->first()->id,
                        'type' => $user->golfBalls->first()->getMorphClass(),
                    ]
                ]
            )->assertCreated();

        $response
            ->assertJson(fn (AssertableJson $json) =>
                $json
                ->where('golf_bag_id', $user->golfBags()->first()->id)
                ->where('baggable_id', $user->golfBalls()->first()->id)
                ->where('baggable_type', $user->golfBalls->first()->getMorphClass())
                ->etc()
            );
    }
}
