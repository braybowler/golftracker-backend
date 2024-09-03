<?php

namespace Tests\Feature\Controllers\PracticeSessionController;

use App\Enums\ClubCategory;
use App\Enums\ClubType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class StorePracticeSessionControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_stores_a_practicesession(): void
    {
        $user = User::factory()->create();
        Carbon::setTestNow(now());
        $date = Carbon::now()->toDateTimeString();
        $note = "Test note";
        $start_time = Carbon::now()->toDateTimeString();;
        $end_time = Carbon::now()->toDateTimeString();;
        $temperature = 20;
        $wind_speed = 15;

        $response = $this->actingAs($user)
            ->postJson(
                route('practicesessions.store'),
                [
                    'date' => $date,
                    'note' => $note,
                    'start_time' => $start_time,
                    'end_time' => $end_time,
                    'temperature' => $temperature,
                    'wind_speed' => $wind_speed,
                ]
            )->assertCreated();

        $response
            ->assertJson(fn (AssertableJson $json) => $json->where('user_id', $user->id)
                ->where('date', Carbon::parse($date)->toDateTimeString())
                ->where('note', $note)
                ->where('start_time', Carbon::parse($start_time)->toDateTimeString())
                ->where('end_time', Carbon::parse($end_time)->toDateTimeString())
                ->where('temperature', $temperature)
                ->where('wind_speed', $wind_speed)
                ->etc()
            );
    }

    public function test_it_associates_the_practicesession_with_the_requesting_user(): void
    {
        $user = User::factory()->create();
        $this->assertDatabaseCount('practice_sessions', 0);
        Carbon::setTestNow(now());
        $date = Carbon::now()->toDateTimeString();
        $note = "Test note";
        $start_time = Carbon::now()->toDateTimeString();;
        $end_time = Carbon::now()->toDateTimeString();;
        $temperature = 20;
        $wind_speed = 15;

        $this->actingAs($user)
            ->postJson(
                route('practicesessions.store'),
                [
                    'date' => $date,
                    'note' => $note,
                    'start_time' => $start_time,
                    'end_time' => $end_time,
                    'temperature' => $temperature,
                    'wind_speed' => $wind_speed,
                ]
            )->assertCreated();

        $this->assertDatabaseCount('practice_sessions', 1);
        $this->assertDatabaseHas('practice_sessions', ['user_id' => $user->id]);
    }

    public function test_it_does_not_allow_guest_access(): void
    {
        $this->postJson(
            route('practicesessions.store'),
        )->assertUnauthorized();
    }

    public function test_it_returns_a_json_resource_on_successful_store_requests(): void
    {
        $user = User::factory()->create();
        $this->assertDatabaseCount('practice_sessions', 0);
        Carbon::setTestNow(now());
        $date = Carbon::now()->toDateTimeString();
        $note = "Test note";
        $start_time = Carbon::now()->toDateTimeString();;
        $end_time = Carbon::now()->toDateTimeString();;
        $temperature = 20;
        $wind_speed = 15;

        $response = $this->actingAs($user)
            ->postJson(
                route('practicesessions.store'),
                [
                    'date' => $date,
                    'note' => $note,
                    'start_time' => $start_time,
                    'end_time' => $end_time,
                    'temperature' => $temperature,
                    'wind_speed' => $wind_speed,
                ]
            )->assertCreated();

        $response
            ->assertJson(fn (AssertableJson $json) => $json->where('user_id', $user->id)
                ->where('date', Carbon::parse($date)->toDateTimeString())
                ->where('note', $note)
                ->where('start_time', Carbon::parse($start_time)->toDateTimeString())
                ->where('end_time', Carbon::parse($end_time)->toDateTimeString())
                ->where('temperature', $temperature)
                ->where('wind_speed', $wind_speed)
                ->etc()
            );
    }
}
