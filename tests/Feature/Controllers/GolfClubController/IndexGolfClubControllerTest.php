<?php

namespace Tests\Feature\Controllers\GolfBagController;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class IndexGolfClubControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_all_golfclubs_for_a_user_when_fewer_than_10_exist(): void
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

    public function test_it_paginates_golfclub_index_responses_with_10_per_page_when_greater_than_10_exist(): void
    {
        $this->markTestIncomplete('TODO');
    }
}
