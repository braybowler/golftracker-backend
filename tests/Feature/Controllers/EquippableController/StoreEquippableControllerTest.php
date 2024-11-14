<?php

namespace Tests\Feature\Controllers\EquippableController;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class StoreEquippableControllerTest extends TestCase
{
    public function test_it_stores_an_equippable(): void
    {
        $user = User::factory()->hasGolfClubs()->create();
        $this->assertDatabaseCount('equippables', 0);

        $this->actingAs($user)
            ->postJson(
                route('equippables.store'),
                [
                    'user' => [
                        'id' => $user->id
                    ],
                    'equippable' => [
                        'id' => $user->golfClubs->first()->id,
                        'type' => $user->golfClubs->first()->getMorphClass(),
                    ]
                ]
            )->assertCreated();

        $this->assertDatabaseCount('equippables', 1);
    }


    public function test_it_associates_the_equippable_with_the_user(): void
    {
        $user = User::factory()->hasGolfClubs()->hasGolfBalls()->create();
        $this->assertDatabaseCount('equippables', 0);

        $this->actingAs($user)
            ->postJson(
                route('equippables.store'),
                [
                    'user' => [
                        'id' => $user->id
                    ],
                    'equippable' => [
                        'id' => $user->golfClubs->first()->id,
                        'type' => $user->golfClubs->first()->getMorphClass(),
                    ]
                ]
            )->assertCreated();

        $this->assertDatabaseCount('equippables', 1);
        $this->assertDatabaseHas('equippables', ['user_id' => $user->id]);
    }

    public function test_it_does_not_allow_guest_access(): void
    {
        $this->postJson(
            route('equippables.store')
        )->assertUnauthorized();
    }

    public function test_it_returns_a_json_resource_on_successful_store_requests(): void
    {
        $user = User::factory()->hasGolfClubs()->hasGolfBalls()->create();
        $this->assertDatabaseCount('equippables', 0);

        $response = $this->actingAs($user)
            ->postJson(
                route('equippables.store'),
                [
                    'user' => [
                        'id' => $user->id
                    ],
                    'equippable' => [
                        'id' => $user->golfClubs->first()->id,
                        'type' => $user->golfClubs->first()->getMorphClass(),
                    ]
                ]
            )->assertCreated();

        $response
            ->assertJson(fn (AssertableJson $json) =>
                $json
                ->where('user_id', $user->id)
                ->where('equippable_id', $user->golfClubs()->first()->id)
                ->where('equippable_type', $user->golfClubs->first()->getMorphClass())
                ->etc()
            );
    }
}
