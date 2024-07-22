<?php

namespace Database\Factories;

use App\Models\GolfBag;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class GolfBagFactory extends Factory
{
    protected $model = GolfBag::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'make' => $this->faker->word(),
            'model' => $this->faker->word(),
            'nickname' => $this->faker->word(),
        ];
    }
}
