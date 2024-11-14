<?php

namespace Tests\Unit\Models\GolfBag;

use App\Models\GolfBag;
use App\Models\GolfBall;
use App\Models\GolfClub;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GolfBagTest extends TestCase
{
    public function test_it_can_retrieve_specific_polymorphic_relationship_models(): void
    {
        $golfBag = GolfBag::factory()
                        ->hasAttached(
                            GolfBall::factory()->count(1)
                        )
                        ->hasAttached(
                            GolfClub::factory()->count(1)
                        )
                        ->create();

        $golfBall = $golfBag->golfBalls()->first();
        $golfClub = $golfBag->golfClubs()->first();

        $this->assertModelExists($golfBall);
        $this->assertInstanceOf(GolfBall::class, $golfBall);
        $this->assertModelExists($golfClub);
        $this->assertInstanceOf(GolfClub::class, $golfClub);
    }

    public function test_it_can_retrieve_all_polymorphic__models(): void
    {
        $golfBallCount = 2;
        $golfClubCount = 2;
        $golfBag = GolfBag::factory()
            ->hasAttached(
                GolfBall::factory()->count($golfBallCount)
            )
            ->hasAttached(
                GolfClub::factory()->count($golfClubCount)
            )
            ->create();

        $baggables = $golfBag->baggables()->toArray();

        $this->assertEquals($golfBallCount + $golfClubCount, count($baggables));
    }
}
