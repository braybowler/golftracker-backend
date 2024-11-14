<?php

namespace Tests\Feature\Controllers\PracticeSessionController;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DestroyPracticeSessionControllerTest extends TestCase
{
    public function test_it_deletes_a_practicesession()
    {
        $user = User::factory()->hasPracticeSessions()->create();
        $practiceSession = $user->practiceSessions()->first();

        $this->assertDatabaseCount('practice_sessions', 1);

        $this->actingAs($user)
            ->deleteJson(route('practicesessions.destroy', ['practicesession' => $practiceSession->id]))
            ->assertNoContent();

        $this->assertDatabaseCount('practice_sessions', 0);
    }

    public function test_it_does_not_allow_guest_access(): void
    {
        $this->deleteJson(route('practicesessions.destroy', ['practicesession' => 1]))
            ->assertUnauthorized();
    }

    public function test_it_does_not_allow_access_to_other_users_golfclubs(): void
    {
        $user = User::factory()->hasPracticeSessions(1)->create();
        $userTwo = User::factory()->hasPracticeSessions(1)->create();

        $inaccessiblePracticeSession = $userTwo->practiceSessions()->first();

        $this->actingAs($user)
            ->deleteJson(
                route('practicesessions.destroy', ['practicesession' => $inaccessiblePracticeSession->id]))
            ->assertNotFound();
    }

    public function test_it_returns_a_404_status_code_for_delete_requests_for_practicesessions_that_do_not_exist(): void
    {
        $user = User::factory()->hasPracticeSessions(1)->create();

        $this->actingAs($user)
            ->deleteJson(route('practicesessions.destroy', ['practicesession' => -1]))
            ->assertNotFound();
    }
}
