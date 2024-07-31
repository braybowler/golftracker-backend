<?php

namespace Tests\Feature\Controllers\GolfBallController;

use App\Enums\ClubCategory;
use App\Enums\ClubType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UpdateGolfBallControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_updates_a_golfball()
    {
        $make = 'Titleist';
        $model = 'AVX';

        $user = User::factory()->hasGolfBalls(1, [
            'make' => $make,
            'model' => $model,
        ])->create();

        $golfBall = $user->golfBalls()->first();

        $this->assertDatabaseHas('golf_balls', [
            'user_id' => $user->id,
            'make' => $make,
            'model' => $model,
        ]);

        $make = 'Some Other Make';
        $model = 'Some Other Model';

        $response = $this->actingAs($user)
            ->patchJson(
                route('golfballs.update', ['golfball' => $golfBall->id]),
                [
                    'make' => $make,
                    'model' => $model,
                ])
            ->assertOk();

        $this->assertDatabaseHas('golf_balls', [
            'make' => $make,
            'model' => $model,
        ]);

        $response
            ->assertJson(fn (AssertableJson $json) => $json->where('user_id', $user->id)
                ->where('id', $golfBall->id)
                ->where('make', $make)
                ->where('model', $model)
                ->etc()
            );
    }

    public function test_it_does_not_allow_guest_access(): void
    {
        $this->patchJson(route('golfballs.update', ['golfball' => 1]))
            ->assertUnauthorized();
    }

    public function test_it_does_not_allow_access_to_other_users_golfballs(): void
    {
        $make = 'Titleist';
        $model = 'AVX';

        $user = User::factory()->hasGolfBalls(1, [
            'make' => $make,
            'model' => $model,
        ])->create();

        $userTwo = User::factory()->hasGolfBalls(1, [
            'make' => $make,
            'model' => $model,
        ])->create();

        $inaccessibleGolfBall = $userTwo->golfBalls()->first();

        $make = 'Some Other Make';
        $model = 'Some Other Model';

        $this->actingAs($user)
            ->patchJson(
                route('golfballs.update', ['golfball' => $inaccessibleGolfBall->id]),
                [
                    'make' => $make,
                    'model' => $model,
                ])
            ->assertNotFound();
    }

    public function test_it_returns_a_404_status_code_for_patch_requests_for_golfballs_that_do_not_exist(): void
    {
        $user = User::factory()->hasGolfBalls(1)->create();

        $this->actingAs($user)
            ->patchJson(route('golfballs.update', ['golfball' => -1]), [
                'make' => 'Titleist',
                'model' => 'AVX',
            ])->assertNotFound();
    }
}
