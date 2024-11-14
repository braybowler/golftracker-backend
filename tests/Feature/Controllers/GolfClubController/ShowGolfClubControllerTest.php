<?php

namespace Tests\Feature\Controllers\GolfClubController;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ShowGolfClubControllerTest extends TestCase
{
    public function test_it_returns_the_golfclub_identified_by_the_request_id_parameter(): void
    {
        $user = User::factory()->hasGolfClubs(5)->create();
        $golfClub = $user->golfClubs()->first();

        $response = $this->actingAs($user)
            ->getJson(route('golfclubs.show', ['golfclub' => $golfClub->id]))
            ->assertOk();

        $response
            ->assertJson(fn (AssertableJson $json) => $json->where('user_id', $user->id)
                ->where('id', $golfClub->id)
                ->etc()
            );
    }

    public function test_it_does_not_allow_guest_access(): void
    {
        $this->getJson(route('golfclubs.show', ['golfclub' => 1]))
            ->assertUnauthorized();
    }

    public function test_it_does_not_allow_access_to_other_users_golfclubs(): void
    {
        $user = User::factory()->hasGolfClubs()->create();
        $userTwo = User::factory()->hasGolfClubs()->create();
        $inaccessibleGolfClub = $userTwo->golfClubs()->first();

        $this->actingAs($user)->getJson(route('golfclubs.show', [
            'golfclub' => $inaccessibleGolfClub->id,
        ]))->assertNotFound();
    }

    public function test_it_returns_a_404_status_code_for_get_requests_for_golfclubs_that_do_not_exist(): void
    {
        $user = User::factory()->hasGolfClubs(1)->create();

        $this->actingAs($user)
            ->getJson(route('golfclubs.show', ['golfclub' => -1]))
            ->assertNotFound();
    }
}
