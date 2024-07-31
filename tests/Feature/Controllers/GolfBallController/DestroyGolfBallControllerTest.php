<?php

namespace Tests\Feature\Controllers\GolfBallController;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DestroyGolfBallControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_deletes_a_golfball()
    {
        $user = User::factory()->hasGolfBalls()->create();
        $golfBall = $user->golfBalls()->first();

        $this->assertDatabaseCount('golf_balls', 1);

        $this->actingAs($user)
            ->deleteJson(route('golfballs.destroy', ['golfball' => $golfBall->id]))
            ->assertNoContent();

        $this->assertDatabaseCount('golf_balls', 0);
    }

    public function test_it_does_not_allow_guest_access(): void
    {
        $this->deleteJson(route('golfballs.destroy', ['golfball' => 1]))
            ->assertUnauthorized();
    }

    public function test_it_does_not_allow_access_to_other_users_golfballs(): void
    {
        $user = User::factory()->hasGolfBalls(1)->create();
        $userTwo = User::factory()->hasGolfBalls(1)->create();

        $inaccessibleGolfBall = $userTwo->golfBalls()->first();

        $this->actingAs($user)
            ->deleteJson(
                route('golfballs.destroy', ['golfball' => $inaccessibleGolfBall->id]))
            ->assertNotFound();
    }

    public function test_it_returns_a_404_status_code_for_delete_requests_for_golfclubs_that_do_not_exist(): void
    {
        $user = User::factory()->hasGolfClubs(1)->create();

        $this->actingAs($user)
            ->deleteJson(route('golfclubs.destroy', ['golfclub' => -1])
            )->assertNotFound();
    }
}
