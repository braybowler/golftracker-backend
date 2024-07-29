<?php

namespace Tests\Feature\Requests\GolfClub;

use App\Enums\ClubCategory;
use App\Enums\ClubType;
use App\Models\User;
use Tests\TestCase;

class GolfClubRequestTest extends TestCase
{
    public function test_it_validates_the_make_attribute_of_a_golfclub_request_is_required()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson(
                route('golfclubs.store'),
                [
                    'make' => '',
                    'model' => 'Test String',
                    'loft' => 46,
                    'club_category' => ClubCategory::WEDGE->value,
                    'club_type' => ClubType::PW->value,
                    'carry_distance' => 130,
                    'total_distance' => 130,
                ]
            )->assertUnprocessable();
    }

    public function test_it_validates_the_make_attribute_of_a_golfclub_request_must_be_a_string()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson(
                route('golfclubs.store'),
                [
                    'make' => 10,
                    'model' => 'Test String',
                    'loft' => 46,
                    'club_category' => ClubCategory::WEDGE->value,
                    'club_type' => ClubType::PW->value,
                    'carry_distance' => 130,
                    'total_distance' => 130,
                ]
            )->assertUnprocessable();
    }

    public function test_it_validates_the_model_attribute_of_a_golfclub_request_is_required()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson(
                route('golfclubs.store'),
                [
                    'make' => 'Test Make',
                    'model' => '',
                    'loft' => 46,
                    'club_category' => ClubCategory::WEDGE->value,
                    'club_type' => ClubType::PW->value,
                    'carry_distance' => 130,
                    'total_distance' => 130,
                ]
            )->assertUnprocessable();
    }

    public function test_it_validates_the_model_attribute_of_a_golfclub_request_must_be_a_string()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson(
                route('golfclubs.store'),
                [
                    'make' => 'Test Make',
                    'model' => 10,
                    'loft' => 46,
                    'club_category' => ClubCategory::WEDGE->value,
                    'club_type' => ClubType::PW->value,
                    'carry_distance' => 130,
                    'total_distance' => 130,
                ]
            )->assertUnprocessable();
    }

    public function test_the_carry_distance_attribute_of_a_golfclub_request_is_not_required()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson(
                route('golfclubs.store'),
                [
                    'make' => 'Test Make',
                    'model' => 'Test Model',
                    'loft' => 46,
                    'club_category' => ClubCategory::WEDGE->value,
                    'club_type' => ClubType::PW->value,
                    'carry_distance' => null,
                    'total_distance' => 130,
                ]
            )->assertCreated();
    }

    public function test_it_validates_that_the_carry_distance_attribute_of_a_golfbag_request_must_be_an_int_if_present()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson(
                route('golfclubs.store'),
                [
                    'make' => 'Test Make',
                    'model' => 'Test Model',
                    'loft' => 46,
                    'club_category' => ClubCategory::WEDGE->value,
                    'club_type' => ClubType::PW->value,
                    'carry_distance' => 'Test',
                    'total_distance' => 130,
                ]
            )->assertUnprocessable();
    }

    public function test_the_total_distance_attribute_of_a_golfclub_request_is_not_required()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson(
                route('golfclubs.store'),
                [
                    'make' => 'Test Make',
                    'model' => 'Test Model',
                    'loft' => 46,
                    'club_category' => ClubCategory::WEDGE->value,
                    'club_type' => ClubType::PW->value,
                    'carry_distance' => 130,
                    'total_distance' => null,
                ]
            )->assertCreated();
    }

    public function test_it_validates_that_the_total_distance_attribute_of_a_golfbag_request_must_be_an_int_if_present()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson(
                route('golfclubs.store'),
                [
                    'make' => 'Test Make',
                    'model' => 'Test Model',
                    'loft' => 46,
                    'club_category' => ClubCategory::WEDGE->value,
                    'club_type' => ClubType::PW->value,
                    'carry_distance' => 130,
                    'total_distance' => 'Test',
                ]
            )->assertUnprocessable();
    }

    public function test_it_validates_that_the_loft_attribute_of_a_golfbag_request_must_be_an_int_if_present()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson(
                route('golfclubs.store'),
                [
                    'make' => 'Test Make',
                    'model' => 'Test Model',
                    'loft' => 'Test',
                    'club_category' => ClubCategory::WEDGE->value,
                    'club_type' => ClubType::PW->value,
                    'carry_distance' => 130,
                    'total_distance' => 130,
                ]
            )->assertUnprocessable();
    }

    public function test_the_loft_attribute_of_a_golfclub_request_is_not_required()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson(
                route('golfclubs.store'),
                [
                    'make' => 'Test Make',
                    'model' => 'Test Model',
                    'loft' => null,
                    'club_category' => ClubCategory::WEDGE->value,
                    'club_type' => ClubType::PW->value,
                    'carry_distance' => 130,
                    'total_distance' => 130,
                ]
            )->assertCreated();
    }
    public function test_it_validates_the_club_category_attribute_of_a_golfclub_request_is_required()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson(
                route('golfclubs.store'),
                [
                    'make' => '',
                    'model' => 'Test String',
                    'loft' => 46,
                    'club_category' => null,
                    'club_type' => ClubType::PW->value,
                    'carry_distance' => 130,
                    'total_distance' => 130,
                ]
            )->assertUnprocessable();
    }

    public function test_it_validates_the_club_type_attribute_of_a_golfclub_request_is_required()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson(
                route('golfclubs.store'),
                [
                    'make' => '',
                    'model' => 'Test String',
                    'loft' => 46,
                    'club_category' => ClubCategory::WEDGE->value,
                    'club_type' => null,
                    'carry_distance' => 130,
                    'total_distance' => 130,
                ]
            )->assertUnprocessable();
    }
}
