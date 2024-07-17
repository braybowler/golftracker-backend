<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use App\Models\User;

class IndexGolfBagControllerTest extends TestCase
{
    public function test_it_returns_all_golfbags_for_a_user(): void
    {
        $user = User::factory()->hasGolfBags(10)->create();

        $this->actingAs($user)
            ->getJson(route('golfbags.index'))
            ->assertOk();
    }
}
