<?php

namespace Tests\Feature\Controllers\GolfClubController;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DestroyGolfClubControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_deletes_a_golfclub()
    {
        $user = User::factory()->hasGolfClubs()->create();
        $golfClub = $user->golfClubs()->first();

        $this->assertDatabaseCount('golf_clubs', 1);

        $this->actingAs($user)
            ->deleteJson(route('golfclubs.destroy', ['golfclub' => $golfClub->id]))
            ->assertNoContent();

        $this->assertDatabaseCount('golf_clubs', 0);
    }

    public function test_it_does_not_allow_guest_access(): void
    {
        $this->deleteJson(route('golfclubs.destroy', ['golfclub' => 1]))
            ->assertUnauthorized();
    }

    public function test_it_does_not_allow_access_to_other_users_golfclubs(): void
    {
        $user = User::factory()->hasGolfClubs(1)->create();
        $userTwo = User::factory()->hasGolfClubs(1)->create();

        $inaccessibleGolfClub = $userTwo->golfClubs()->first();

        $this->actingAs($user)
            ->deleteJson(
                route('golfclubs.destroy', ['golfclub' => $inaccessibleGolfClub->id]))
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
