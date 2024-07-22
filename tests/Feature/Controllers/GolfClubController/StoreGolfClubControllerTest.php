<?php

namespace Tests\Feature\Controllers\GolfBagController;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class StoreGolfClubControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_stores_a_golfclub(): void
    {
        $this->markTestIncomplete('TODO');
    }

    public function test_it_associates_the_golfclub_with_the_requesting_user(): void
    {
        $this->markTestIncomplete('TODO');
    }

    public function test_it_does_not_allow_guest_access(): void
    {
        $this->markTestIncomplete('TODO');
    }

    public function test_it_returns_a_json_resource_on_successful_store_requests(): void
    {
        $this->markTestIncomplete('TODO');
    }
}
