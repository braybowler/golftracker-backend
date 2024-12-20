<?php

namespace App\Providers;

use App\Models\GolfBall;
use App\Models\GolfClub;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {
        Relation::enforceMorphMap([
            GolfBall::class,
            GolfClub::class,
        ]);
    }
}
