<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'last_active_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function golfBags(): HasMany
    {
        return $this->hasMany(GolfBag::class);
    }

    public function golfBalls(): HasMany
    {
        return $this->hasMany(GolfBall::class);
    }

    public function golfClubs(): HasMany
    {
        return $this->hasMany(GolfClub::class);
    }

    public function practiceSessions(): HasMany
    {
        return $this->hasMany(PracticeSession::class);
    }

    public function yardages(): HasManyThrough
    {
        return $this->hasManyThrough(Yardage::class, GolfClub::class);
    }

    public function equippables()
    {
        return Equippable::where('user_id', $this->id)->get();
    }
}
