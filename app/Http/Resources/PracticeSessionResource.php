<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PracticeSessionResource extends JsonResource
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
            'user_id' => $this->user_id,
            'date' => $this->date,
            'note' => $this->note,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'temperature' => $this->temperature,
            'wind_speed' => $this->wind_speed,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
