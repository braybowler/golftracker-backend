<?php

namespace Tests\Unit\Models\GolfBall;

use App\Models\GolfBag;
use App\Models\GolfBall;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GolfBallTest extends TestCase
{
    use RefreshDatabase;
    public function test_it_can_retrieve_polymorphic_relationship_models(): void
    {
        $golfBall = GolfBall::factory()
                        ->hasAttached(
                            GolfBag::factory()->count(1)
                        )
                        ->create();

        $golfBag = $golfBall->golfBags()->first();

        $this->assertModelExists($golfBag);
        $this->assertInstanceOf(GolfBag::class, $golfBag);
    }
}
