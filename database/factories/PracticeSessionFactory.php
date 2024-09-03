<?php

namespace Database\Factories;

use App\Models\PracticeSession;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PracticeSessionFactory extends Factory
{
    protected $model = PracticeSession::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'date' => Carbon::now(),
            'note' => $this->faker->word(),
            'start_time' => Carbon::now(),
            'end_time' => Carbon::now(),
            'temperature' => $this->faker->randomNumber(),
            'wind_speed' => $this->faker->randomNumber(),
        ];
    }
}
