<?php

namespace App\Models;

use App\Enums\ClubType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class GolfClub extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function booted(): void
    {
        static::saving(function (self $golfClub) {
            $golfClub->sort_index = ClubType::from($golfClub->club_type)->sortIndex();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function golfBags(): MorphToMany
    {
        return $this->morphToMany(GolfBag::class, 'baggable');
    }

    public function yardages(): HasMany
    {
        return $this->hasMany(Yardage::class);
    }
}
