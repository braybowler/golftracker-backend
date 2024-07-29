<?php

namespace Database\Factories;

use App\Enums\ClubCategory;
use App\Enums\ClubType;
use App\Models\GolfClub;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class GolfClubFactory extends Factory
{
    protected $model = GolfClub::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'make' => $this->faker->word(),
            'model' => $this->faker->word(),
            'club_category' => $this->faker->randomElement(ClubCategory::toArray()),
            'club_type' => $this->faker->randomElement(ClubType::toArray()),
            'carry_distance' => $this->faker->randomNumber(),
            'total_distance' => $this->faker->randomNumber(),
            'loft' => $this->faker->randomNumber(),
        ];
    }
}
