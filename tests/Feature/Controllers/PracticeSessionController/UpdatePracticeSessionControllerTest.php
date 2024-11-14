<?php

namespace Tests\Feature\Controllers\PracticeSessionController;

use App\Enums\ClubCategory;
use App\Enums\ClubType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UpdatePracticeSessionControllerTest extends TestCase
{
    public function test_it_updates_a_practicesession()
    {
        Carbon::setTestNow(now());
        $date = Carbon::now()->toDateTimeString();
        $note = "Test note";
        $start_time = Carbon::now()->toDateTimeString();;
        $end_time = Carbon::now()->toDateTimeString();;
        $temperature = 20;
        $wind_speed = 15;

        $user = User::factory()->hasPracticeSessions(1, [
            'date' => $date,
            'note' => $note,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'temperature' => $temperature,
            'wind_speed' => $wind_speed,
        ])->create();

        $practiceSession = $user->practiceSessions()->first();

        $this->assertDatabaseHas('practice_sessions', [
            'date' => $date,
            'note' => $note,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'temperature' => $temperature,
            'wind_speed' => $wind_speed,
        ]);

        $otherNote = 'Some Other Note';

        $response = $this->actingAs($user)
            ->patchJson(
                route('practicesessions.update', ['practicesession' => $practiceSession->id]),
                [
                    'date' => $date,
                    'note' => $otherNote,
                    'start_time' => $start_time,
                    'end_time' => $end_time,
                    'temperature' => $temperature,
                    'wind_speed' => $wind_speed,
                ])
            ->assertOk();

        $this->assertDatabaseHas('practice_sessions', [
            'date' => $date,
            'note' => $otherNote,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'temperature' => $temperature,
            'wind_speed' => $wind_speed,
        ]);

        $response
            ->assertJson(fn (AssertableJson $json) => $json->where('user_id', $user->id)
                ->where('date', $date)
                ->where( 'note', $otherNote)
                ->where( 'start_time', $start_time)
                ->where( 'end_time', $end_time)
                ->where( 'temperature', $temperature)
                ->where( 'wind_speed', $wind_speed)
                ->etc()
            );
    }

    public function test_it_does_not_allow_guest_access(): void
    {
        $this->patchJson(route('practicesessions.update', ['practicesession' => 1]))
            ->assertUnauthorized();
    }

    public function test_it_does_not_allow_access_to_other_users_practicesessions(): void
    {
        Carbon::setTestNow(now());
        $date = Carbon::now()->toDateTimeString();
        $note = "Test note";
        $start_time = Carbon::now()->toDateTimeString();;
        $end_time = Carbon::now()->toDateTimeString();;
        $temperature = 20;
        $wind_speed = 15;

        $user = User::factory()->hasPracticeSessions(1, [
            'date' => $date,
            'note' => $note,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'temperature' => $temperature,
            'wind_speed' => $wind_speed,
        ])->create();

        $userTwo = User::factory()->hasPracticeSessions(1, [
            'date' => $date,
            'note' => $note,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'temperature' => $temperature,
            'wind_speed' => $wind_speed,
        ])->create();

        $inaccessiblePracticeSession = $userTwo->practiceSessions()->first();

        $note = 'Some Other Note';

        $this->actingAs($user)
            ->patchJson(
                route('practicesessions.update', ['practicesession' => $inaccessiblePracticeSession->id]),
                [
                    'date' => $date,
                    'note' => $note,
                    'start_time' => $start_time,
                    'end_time' => $end_time,
                    'temperature' => $temperature,
                    'wind_speed' => $wind_speed,
                ])
            ->assertNotFound();
    }

    public function test_it_returns_a_404_status_code_for_patch_requests_for_practicesessions_that_do_not_exist(): void
    {
        $user = User::factory()->hasPracticeSessions(1)->create();

        $date = Carbon::now()->toDateTimeString();
        $note = "Test note";
        $start_time = Carbon::now()->toDateTimeString();;
        $end_time = Carbon::now()->toDateTimeString();;
        $temperature = 20;
        $wind_speed = 15;

        $this->actingAs($user)
            ->patchJson(route('practicesessions.update', ['practicesession' => -1]), [
                'date' => $date,
                'note' => $note,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'temperature' => $temperature,
                'wind_speed' => $wind_speed,
            ])->assertNotFound();
    }
}
