<?php

namespace Database\Factories;

use App\Models\GolfBall;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class GolfBallFactory extends Factory
{
    protected $model = GolfBall::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'make' => $this->faker->word(),
            'model' => $this->faker->word(),
        ];
    }
}
