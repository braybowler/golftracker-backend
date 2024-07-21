<?php

namespace Tests\Feature\Controllers\GolfBagController;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ShowGolfBagControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_the_golfbag_identified_by_the_request_id_parameter(): void
    {
        $user = User::factory()->hasGolfBags(5)->create();
        $golfbag = $user->golfBags()->first();

        $response = $this->actingAs($user)
            ->getJson(route('golfbags.show', ['golfbag' => $golfbag->id]))
            ->assertOk();

        $response
            ->assertJson(fn (AssertableJson $json) => $json->where('user_id', $user->id)
                ->where('id', $golfbag->id)
                ->etc()
            );
    }

    public function test_it_does_not_allow_guest_access(): void
    {
        $this->getJson(route('golfbags.show', ['golfbag' => 1]))
            ->assertUnauthorized();
    }

    public function test_it_does_not_allow_access_to_other_users_golfbags(): void
    {
        $user = User::factory()->hasGolfBags()->create();
        $userTwo = User::factory()->hasGolfBags()->create();
        $inaccessibleGolfBag = $userTwo->golfBags()->first();

        $this->actingAs($user)->getJson(route('golfbags.show', [
            'golfbag' => $inaccessibleGolfBag->id,
        ]))->assertNotFound();
    }

    public function test_it_returns_a_404_status_code_for_get_requests_for_golfbags_that_do_not_exist(): void
    {
        $user = User::factory()->hasGolfBags(1)->create();

        $this->actingAs($user)
            ->getJson(route('golfbags.show', ['golfbag' => -1]))
            ->assertNotFound();
    }
}
