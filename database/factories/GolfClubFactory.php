<?php

namespace Database\Factories;

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
            'carry_distance' => $this->faker->randomNumber(),
            'total_distance' => $this->faker->randomNumber(),
            'loft' => $this->faker->randomNumber(),
        ];
    }
}
