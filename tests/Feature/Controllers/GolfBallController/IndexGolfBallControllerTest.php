<?php

namespace Tests\Feature\Controllers\GolfBallController;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class IndexGolfBallControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_all_golfballs_for_a_user_when_fewer_than_10_exist(): void
    {
        $numGolfBalls = 5;
        $user = User::factory()->hasGolfBalls($numGolfBalls)->create();

        $response = $this->actingAs($user)
            ->getJson(route('golfballs.index'))
            ->assertOk();

        $response
            ->assertJson(fn (AssertableJson $json) => $json->has('meta')
                ->has('links')
                ->has('data', $numGolfBalls));
    }

    public function test_it_does_not_allow_guest_access(): void
    {
        User::factory()->hasGolfBalls(10)->create();

        $this->getJson(route('golfballs.index'))
            ->assertUnauthorized();
    }

    public function test_it_does_not_allow_access_to_other_users_golfballs(): void
    {
        $user = User::factory()->hasGolfBalls(3)->create();
        User::factory()->hasGolfBalls(3)->create();

        $response = $this->actingAs($user)
            ->getJson(route('golfballs.index'))
            ->assertOk();

        $response
            ->assertJson(fn (AssertableJson $json) => $json
                ->has('meta')
                ->has('links')
                ->has('data', 3, fn (AssertableJson $json) => $json->where('user_id', $user->id)
                    ->etc()));
    }

    public function test_it_paginates_golfclub_index_responses_with_10_per_page_when_greater_than_10_exist(): void
    {
        $numGolfBalls = 15;
        $numGolfBallsPerPage = 10;
        $user = User::factory()->hasGolfBalls($numGolfBalls)->create();

        $this->assertDatabaseCount('golf_balls', $numGolfBalls);

        $response = $this->actingAs($user)
            ->getJson(route('golfballs.index'))
            ->assertOk();

        $response
            ->assertJson(fn (AssertableJson $json) => $json->has('meta')
                ->has('links')
                ->has('data', $numGolfBallsPerPage));
    }
}
