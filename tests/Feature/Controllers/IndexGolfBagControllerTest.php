<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class IndexGolfBagControllerTest extends TestCase
{
    use RefreshDatabase;
    public function test_it_returns_all_golfbags_for_a_user_when_fewer_than_10_exist(): void
    {
        $numGolfBags = 5;
        $user = User::factory()->hasGolfBags($numGolfBags)->create();

        $response = $this->actingAs($user)
            ->getJson(route('golfbags.index'))
            ->assertOk();

        $response
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('meta')
                     ->has('links')
                     ->has('data', $numGolfBags));
    }

    public function test_it_does_not_allow_guest_access(): void
    {
        User::factory()->hasGolfBags(10)->create();

        $this->getJson(route('golfbags.index'))
            ->assertUnauthorized();
    }

    public function test_it_does_not_allow_access_to_other_users_golfbags(): void
    {
        $user = User::factory()->hasGolfBags(3)->create();
        User::factory()->hasGolfBags(3)->create();

        $response = $this->actingAs($user)
            ->getJson(route('golfbags.index'))
            ->assertOk();

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->has('meta')
                ->has('links')
                ->has('data', 3, fn (AssertableJson $json) =>
                    $json->where('user_id', $user->id)
                         ->etc()));
    }

    public function test_it_paginates_golfbag_index_responses_with_10_per_page_when_greater_than_10_exist(): void
    {
        $numGolfbags = 15;
        $numGolfbagsPerPage = 10;
        $user = User::factory()->hasGolfBags($numGolfbags)->create();

        $this->assertDatabaseCount('golf_bags', $numGolfbags );

        $response = $this->actingAs($user)
            ->getJson(route('golfbags.index'))
            ->assertOk();

        $response
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('meta')
                     ->has('links')
                     ->has('data', $numGolfbagsPerPage));
    }
}
