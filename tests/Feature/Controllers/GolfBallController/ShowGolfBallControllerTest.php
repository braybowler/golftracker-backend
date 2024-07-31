<?php

namespace Tests\Feature\Controllers\GolfBallController;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ShowGolfBallControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_the_golfball_identified_by_the_request_id_parameter(): void
    {
        $user = User::factory()->hasGolfBalls(5)->create();
        $golfBall = $user->golfBalls()->first();

        $response = $this->actingAs($user)
            ->getJson(route('golfballs.show', ['golfball' => $golfBall->id]))
            ->assertOk();

        $response
            ->assertJson(fn (AssertableJson $json) => $json->where('user_id', $user->id)
                ->where('id', $golfBall->id)
                ->etc()
            );
    }

    public function test_it_does_not_allow_guest_access(): void
    {
        $this->getJson(route('golfballs.show', ['golfball' => 1]))
            ->assertUnauthorized();
    }

    public function test_it_does_not_allow_access_to_other_users_golfballs(): void
    {
        $user = User::factory()->hasGolfBalls()->create();
        $userTwo = User::factory()->hasGolfBalls()->create();
        $inaccessibleGolfBall = $userTwo->golfBalls()->first();

        $this->actingAs($user)->getJson(route('golfballs.show', [
            'golfball' => $inaccessibleGolfBall->id,
        ]))->assertNotFound();
    }

    public function test_it_returns_a_404_status_code_for_get_requests_for_golfballs_that_do_not_exist(): void
    {
        $user = User::factory()->hasGolfBalls(1)->create();

        $this->actingAs($user)
            ->getJson(route('golfballs.show', ['golfball' => -1]))
            ->assertNotFound();
    }
}
