<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowGolfBagControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_a_golfbag_identified_by_the_request_id_parameter(): void
    {
        $numGolfbags = 5;
        $requestId = 1;
        $user = User::factory()->hasGolfBags($numGolfbags)->create();

        //api/golfbags/{golfbag}
        $response = $this->actingAs($user)
            ->getJson(route('golfbags.show', ['golfbag' => $requestId]))
            ->assertOk();

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('user_id', $user->id)
                ->where('id', $requestId)
                ->etc()
            );
    }
}
