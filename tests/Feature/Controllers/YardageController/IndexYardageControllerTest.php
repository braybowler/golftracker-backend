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
        User::factory()->hasYardages()->create();

        $this->getJson(route('yardages.index'))
            ->assertUnauthorized();
    }

    public function test_it_does_not_allow_access_to_other_users_yardages(): void
    {
        $user = User::factory()->has(
            GolfClub::factory()->has(
                Yardage::factory()->count(3)
            )
        )->create();

        User::factory()->has(
            GolfClub::factory()->has(
                Yardage::factory()->count(3)
            )
        )->create();

        $response = $this->actingAs($user)
            ->getJson(route('yardages.index'))
            ->assertOk();

        $response
            ->assertJson(fn (AssertableJson $json) => $json
                ->has('meta')
                ->has('links')
                ->has('data', 3, fn (AssertableJson $json) => $json->where('golf_club_id', $user->golfClubs()->first()->id)
                    ->etc()));
    }
}
