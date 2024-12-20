<?php

namespace App\Http\Resources;

use App\Models\GolfBall;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GolfBallResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => (new GolfBall())->getMorphClass(),
            'user_id' => $this->user_id,
            'make' => $this->make,
            'model' => $this->model,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
