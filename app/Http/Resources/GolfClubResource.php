<?php

namespace App\Http\Resources;

use App\Models\GolfClub;
use App\Models\Yardage;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GolfClubResource extends JsonResource
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
            'type' => (new GolfClub())->getMorphClass(),
            'user_id' => $this->user_id,
            'sort_index' => $this->sort_index,
            'make' => $this->make,
            'model' => $this->model,
            'club_category' => $this->club_category,
            'club_type' => $this->club_type,
            'loft' => $this->loft,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'yardages' => YardageResource::collection($this->whenLoaded('yardages')),
        ];
    }
}
