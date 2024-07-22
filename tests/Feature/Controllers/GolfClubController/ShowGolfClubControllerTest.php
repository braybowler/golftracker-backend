<?php

namespace Tests\Feature\Controllers\GolfBagController;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ShowGolfClubControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_the_golfclub_identified_by_the_request_id_parameter(): void
    {
        $this->markTestIncomplete('TODO');
    }

    public function test_it_does_not_allow_guest_access(): void
    {
        $this->markTestIncomplete('TODO');
    }

    public function test_it_does_not_allow_access_to_other_users_golfclubs(): void
    {
        $this->markTestIncomplete('TODO');
    }

    public function test_it_returns_a_404_status_code_for_get_requests_for_golfclubs_that_do_not_exist(): void
    {
        $this->markTestIncomplete('TODO');
    }
}
