<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class GolfBag extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function golfBalls(): MorphToMany
    {
        return $this->morphedByMany(GolfBall::class, 'baggable');
    }

    public function golfClubs(): MorphToMany
    {
        return $this->morphedByMany(GolfClub::class, 'baggable');
    }

    public function baggables()
    {
        return Baggable::where('golf_bag_id', $this->id)->get();
    }
}
