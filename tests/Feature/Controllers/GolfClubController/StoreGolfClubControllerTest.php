<?php

namespace Tests\Feature\Controllers\GolfClubController;

use App\Enums\ClubCategory;
use App\Enums\ClubType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class StoreGolfClubControllerTest extends TestCase
{
    public function test_it_stores_a_golfclub(): void
    {
        $user = User::factory()->create();
        $make = 'Titleist';
        $model = 'MB';
        $loft = 46;
        $clubCategory = ClubCategory::WEDGE;
        $clubType = ClubType::PW;

        $response = $this->actingAs($user)
            ->postJson(
                route('golfclubs.store'),
                [
                    'make' => $make,
                    'model' => $model,
                    'loft' => $loft,
                    'club_category' => $clubCategory->value,
                    'club_type' => $clubType->value,
                ]
            )->assertCreated();

        $response
            ->assertJson(fn (AssertableJson $json) => $json->where('user_id', $user->id)
                ->where('make', $make)
                ->where('model', $model)
                ->where('loft', $loft)
                ->where('club_category', $clubCategory->value)
                ->where('club_type', $clubType->value)
                ->etc()
            );
    }

    public function test_it_associates_the_golfclub_with_the_requesting_user(): void
    {
        $user = User::factory()->create();
        $this->assertDatabaseCount('golf_clubs', 0);

        $this->actingAs($user)
            ->postJson(
                route('golfclubs.store'),
                [
                    'make' => 'Titleist',
                    'model' => 'MB',
                    'loft' => 46,
                    'club_category' => ClubCategory::WEDGE->value,
                    'club_type' => ClubType::PW->value,
                ]
            )->assertCreated();

        $this->assertDatabaseCount('golf_clubs', 1);
        $this->assertDatabaseHas('golf_clubs', ['user_id' => $user->id]);
    }

    public function test_it_does_not_allow_guest_access(): void
    {
        $this->postJson(
            route('golfclubs.store'),
            [
                'make' => 'Titleist',
                'model' => 'MB',
                'loft' => 46,
                'club_category' => ClubCategory::WEDGE->value,
                'club_type' => ClubType::PW->value,
            ]
        )->assertUnauthorized();
    }

    public function test_it_returns_a_json_resource_on_successful_store_requests(): void
    {
        $user = User::factory()->create();
        $make = 'Titleist';
        $model = 'MB';
        $loft = 46;
        $clubCategory = ClubCategory::WEDGE;
        $clubType = ClubType::PW;

        $response = $this->actingAs($user)
            ->postJson(
                route('golfclubs.store'),
                [
                    'make' => $make,
                    'model' => $model,
                    'loft' => $loft,
                    'club_category' => $clubCategory->value,
                    'club_type' => $clubType->value,
                ]
            )->assertCreated();

        $response
            ->assertJson(fn (AssertableJson $json) => $json->where('user_id', $user->id)
                ->where('make', $make)
                ->where('model', $model)
                ->where('loft', $loft)
                ->etc()
            );
    }
}
