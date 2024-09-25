<?php

namespace Tests\Feature\Controllers\GolfClubController;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class IndexGolfClubControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_all_golfclubs_for_a_user_when_fewer_than_15_exist(): void
    {
        $numGolfClubs = 5;
        $user = User::factory()->hasGolfClubs($numGolfClubs)->create();

        $response = $this->actingAs($user)
            ->getJson(route('golfclubs.index'))
            ->assertOk();

        $response
            ->assertJson(fn (AssertableJson $json) => $json->has('meta')
                ->has('links')
                ->has('data', $numGolfClubs));
    }

    public function test_it_does_not_allow_guest_access(): void
    {
        User::factory()->hasGolfClubs(10)->create();

        $this->getJson(route('golfclubs.index'))
            ->assertUnauthorized();
    }

    public function test_it_does_not_allow_access_to_other_users_golfclubs(): void
    {
        $user = User::factory()->hasGolfClubs(3)->create();
        User::factory()->hasGolfClubs(3)->create();

        $response = $this->actingAs($user)
            ->getJson(route('golfclubs.index'))
            ->assertOk();

        $response
            ->assertJson(fn (AssertableJson $json) => $json
                ->has('meta')
                ->has('links')
                ->has('data', 3, fn (AssertableJson $json) => $json->where('user_id', $user->id)
                    ->etc()));
    }

    public function test_it_paginates_golfclub_index_responses_with_15_per_page_when_greater_than_15_exist(): void
    {
        $numGolfClubs = 20;
        $numGolfClubsPerPage = 15;
        $user = User::factory()->hasGolfClubs($numGolfClubs)->create();

        $this->assertDatabaseCount('golf_clubs', $numGolfClubs);

        $response = $this->actingAs($user)
            ->getJson(route('golfclubs.index'))
            ->assertOk();

        $response
            ->assertJson(fn (AssertableJson $json) => $json->has('meta')
                ->has('links')
                ->has('data', $numGolfClubsPerPage));
    }
}
