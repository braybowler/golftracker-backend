<?php

namespace Tests\Feature\Controllers\PracticeSessionController;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ShowPracticeSessionControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_the_practicesession_identified_by_the_request_id_parameter(): void
    {
        $user = User::factory()->hasPracticeSessions(5)->create();
        $practiceSession = $user->practiceSessions()->first();

        $response = $this->actingAs($user)
            ->getJson(route('practicesessions.show', ['practicesession' => $practiceSession->id]))
            ->assertOk();

        $response
            ->assertJson(fn (AssertableJson $json) => $json->where('user_id', $user->id)
                ->where('id', $practiceSession->id)
                ->etc()
            );
    }

    public function test_it_does_not_allow_guest_access(): void
    {
        $this->getJson(route('practicesessions.show', ['practicesession' => 1]))
            ->assertUnauthorized();
    }

    public function test_it_does_not_allow_access_to_other_users_practicesessions(): void
    {
        $user = User::factory()->hasPracticeSessions()->create();
        $userTwo = User::factory()->hasPracticeSessions()->create();
        $inaccessiblePracticeSession = $userTwo->practiceSessions()->first();

        $this->actingAs($user)->getJson(route('practicesessions.show', [
            'practicesession' => $inaccessiblePracticeSession->id,
        ]))->assertNotFound();
    }

    public function test_it_returns_a_404_status_code_for_get_requests_for_practicesessions_that_do_not_exist(): void
    {
        $user = User::factory()->hasPracticeSessions(1)->create();

        $this->actingAs($user)
            ->getJson(route('practicesessions.show', ['practicesession' => -1]))
            ->assertNotFound();
    }
}
