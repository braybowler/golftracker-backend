<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateGolfBagControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_updates_a_golfbag()
    {
        $make = 'Test Make';
        $model = 'Test Model';
        $nickname = 'Test Nickname';

        $user = User::factory()->hasGolfBags(1, [
            'make' => $make,
            'model' => $model,
            'nickname' => $nickname,
        ])->create();
        $golfBag = $user->golfBags()->first();

        $this->assertDatabaseHas('golf_bags', [
            'user_id' => $user->id,
            'make' => $make,
            'model' => $model,
            'nickname' => $nickname,
        ]);

        $make = 'Some Other Make';
        $model = 'Some Other Model';
        $nickname = 'Some Other Nickname';

        $response = $this->actingAs($user)
            ->patchJson(
                route('golfbags.update', ['golfbag' => $golfBag->id]),
                [
                    'make' => $make,
                    'model' => $model,
                    'nickname' => $nickname,
                ])
            ->assertOk();

        $this->assertDatabaseHas('golf_bags', [
            'user_id' => $user->id,
            'make' => $make,
            'model' => $model,
            'nickname' => $nickname,
        ]);

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('user_id', $user->id)
                ->where('id', $golfBag->id)
                ->where('make', $make)
                ->where('model', $model)
                ->where('nickname', $nickname)
                ->etc()
            );
    }

    public function test_it_does_not_allow_guest_access(): void
    {
        $this->patchJson(route('golfbags.update', ['golfbag' => 1]))
            ->assertUnauthorized();
    }

    public function test_it_does_not_allow_access_to_other_users_golfbags(): void
    {
        $this->markTestIncomplete('TODO');
    }

    public function test_it_returns_a_404_status_code_for_patch_requests_for_golfbags_that_do_not_exist(): void
    {
        $make = 'Some Other Make';
        $model = 'Some Other Model';
        $nickname = 'Some Other Nickname';

        $user = User::factory()->hasGolfBags(1)->create();

        $this->actingAs($user)
            ->patchJson(route('golfbags.update', ['golfbag' => -1]), [
                'make' => $make,
                'model' => $model,
                'nickname' => $nickname,
            ])->assertNotFound();
    }
}
