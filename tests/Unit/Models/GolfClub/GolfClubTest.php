<?php

namespace Tests\Unit\Models\GolfBag;

use App\Models\GolfBag;
use App\Models\GolfBall;
use App\Models\GolfClub;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GolfClubTest extends TestCase
{
    use RefreshDatabase;
    public function test_it_can_retrieve_polymorphic_relationship_models(): void
    {
        $golfClub = GolfClub::factory()
            ->hasAttached(
                GolfBag::factory()->count(1)
            )
            ->create();

        $golfBag = $golfClub->golfBags()->first();

        $this->assertModelExists($golfBag);
        $this->assertInstanceOf(GolfBag::class, $golfBag);
    }
}
