<?php

namespace Tests\Feature\Controllers\GolfBagController;

use App\Enums\ClubCategory;
use App\Enums\ClubType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UpdateGolfClubControllerTest extends TestCase
{
    public function test_it_updates_a_golfclub()
    {
        $make = 'Titleist';
        $model = 'MB';
        $loft = 46;
        $clubCategory = ClubCategory::WEDGE;
        $clubType = ClubType::PW;

        $user = User::factory()->hasGolfClubs(1, [
            'make' => $make,
            'model' => $model,
            'loft' => $loft,
            'club_category' => $clubCategory->value,
            'club_type' => $clubType->value,
        ])->create();

        $golfClub = $user->golfClubs()->first();

        $this->assertDatabaseHas('golf_clubs', [
            'user_id' => $user->id,
            'make' => $make,
            'model' => $model,
            'loft' => $loft,
            'club_category' => $clubCategory->value,
            'club_type' => $clubType->value,
        ]);

        $make = 'Some Other Make';
        $model = 'Some Other Model';

        $response = $this->actingAs($user)
            ->patchJson(
                route('golfclubs.update', ['golfclub' => $golfClub->id]),
                [
                    'make' => $make,
                    'model' => $model,
                    'loft' => $loft,
                    'club_category' => $clubCategory->value,
                    'club_type' => $clubType->value,
                ])
            ->assertOk();

        $this->assertDatabaseHas('golf_clubs', [
            'make' => $make,
            'model' => $model,
            'loft' => $loft,
            'club_category' => $clubCategory->value,
            'club_type' => $clubType->value,
        ]);

        $response
            ->assertJson(fn (AssertableJson $json) => $json->where('user_id', $user->id)
                ->where('id', $golfClub->id)
                ->where('make', $make)
                ->where('model', $model)
                ->where('loft', $loft)
                ->where('club_category', $clubCategory->value)
                ->where('club_type', $clubType->value)
                ->etc()
            );
    }

    public function test_it_does_not_allow_guest_access(): void
    {
        $this->patchJson(route('golfclubs.update', ['golfclub' => 1]))
            ->assertUnauthorized();
    }

    public function test_it_does_not_allow_access_to_other_users_golfclubs(): void
    {
        $make = 'Titleist';
        $model = 'MB';
        $loft = 46;
        $clubCategory = ClubCategory::WEDGE;
        $clubType = ClubType::PW;

        $user = User::factory()->hasGolfClubs(1, [
            'make' => $make,
            'model' => $model,
            'loft' => $loft,
            'club_category' => $clubCategory->value,
            'club_type' => $clubType->value,
        ])->create();

        $userTwo = User::factory()->hasGolfClubs(1, [
            'make' => $make,
            'model' => $model,
            'loft' => $loft,
            'club_category' => $clubCategory->value,
            'club_type' => $clubType->value,
        ])->create();

        $inaccessibleGolfClub = $userTwo->golfClubs()->first();

        $make = 'Some Other Make';
        $model = 'Some Other Model';

        $this->actingAs($user)
            ->patchJson(
                route('golfclubs.update', ['golfclub' => $inaccessibleGolfClub->id]),
                [
                    'make' => $make,
                    'model' => $model,
                    'loft' => $loft,
                    'club_category' => $clubCategory->value,
                    'club_type' => $clubType->value,
                ])
            ->assertNotFound();
    }

    public function test_it_returns_a_404_status_code_for_patch_requests_for_golfclubs_that_do_not_exist(): void
    {
        $user = User::factory()->hasGolfClubs(1)->create();

        $this->actingAs($user)
            ->patchJson(route('golfclubs.update', ['golfclub' => -1]), [
                'make' => 'Titleist',
                'model' => 'MB',
                'loft' => 46,
                'club_category' => ClubCategory::WEDGE->value,
                'club_type' => ClubType::PW->value,
            ])->assertNotFound();
    }
}
