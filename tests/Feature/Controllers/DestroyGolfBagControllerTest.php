<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DestroyGolfBagControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_deletes_a_golfbag()
    {
        $user = User::factory()->hasGolfBags()->create();
        $golfbag = $user->golfBags()->first();

        $this->assertDatabaseCount('golf_bags', 1);

        $this->actingAs($user)
            ->deleteJson(route('golfbags.destroy', ['golfbag' => $golfbag->id]))
            ->assertNoContent();

        $this->assertDatabaseCount('golf_bags', 0);
    }

    public function test_it_does_not_allow_guest_access(): void
    {
        $this->deleteJson(route('golfbags.destroy', ['golfbag' => 1]))
            ->assertUnauthorized();
    }

    public function test_it_does_not_allow_access_to_other_users_golfbags(): void
    {
        $user = User::factory()->hasGolfBags(1)->create();
        $userTwo = User::factory()->hasGolfBags(1)->create();

        $inaccessibleGolfBag = $userTwo->golfBags()->first();

        $this->actingAs($user)
            ->deleteJson(
                route('golfbags.destroy', ['golfbag' => $inaccessibleGolfBag->id]))
            ->assertNotFound();
    }

    public function test_it_returns_a_404_status_code_for_patch_requests_for_golfbags_that_do_not_exist(): void
    {
        $user = User::factory()->hasGolfBags(1)->create();

        $this->actingAs($user)
            ->deleteJson(route('golfbags.destroy', ['golfbag' => -1])
        )->assertNotFound();
    }
}
