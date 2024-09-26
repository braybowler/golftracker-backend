<?php

namespace Tests\Feature\Controllers\YardageController;

use App\Models\GolfClub;
use App\Models\User;
use App\Models\Yardage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class IndexYardageControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_all_yardages_for_all_user_clubs(): void
    {
        $numYardages = 6;
        $user = User::factory()->has(
            GolfClub::factory()->has(
                Yardage::factory()->count($numYardages)
            )
        )->create();

        $response = $this->actingAs($user)
            ->getJson(route('yardages.index'))->assertOk();

        $response
            ->assertJson(fn (AssertableJson $json) => $json->has('meta')
                ->has('links')
                ->has('data', $numYardages));
    }

    public function test_it_does_not_allow_guest_access(): void
    {
        User::factory()->hasPracticeSessions(10)->create();

        $this->getJson(route('practicesessions.index'))
            ->assertUnauthorized();
    }

    public function test_it_does_not_allow_access_to_other_users_practicesessions(): void
    {
        $user = User::factory()->hasPracticeSessions(3)->create();
        User::factory()->hasPracticeSessions(3)->create();

        $response = $this->actingAs($user)
            ->getJson(route('practicesessions.index'))
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
        $numPracticeSessions = 15;
        $numPracticeSessionsPerPage = 10;
        $user = User::factory()->hasPracticeSessions($numPracticeSessions)->create();

        $this->assertDatabaseCount('practice_sessions', $numPracticeSessions);

        $response = $this->actingAs($user)
            ->getJson(route('practicesessions.index'))
            ->assertOk();

        $response
            ->assertJson(fn (AssertableJson $json) => $json->has('meta')
                ->has('links')
                ->has('data', $numPracticeSessionsPerPage));
    }
}
