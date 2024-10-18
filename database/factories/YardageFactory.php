<?php

namespace Database\Factories;

use App\Enums\SwingType;
use App\Models\GolfClub;
use App\Models\Yardage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class YardageFactory extends Factory
{
    protected $model = Yardage::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'golf_club_id' => GolfClub::factory(),
            'swing_type' => $this->faker->randomElement(SwingType::toArray()),
            'carry_distance' => $this->faker->randomNumber(),
            'total_distance' => $this->faker->randomNumber(),
        ];
    }
}
