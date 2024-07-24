<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphPivot;

class Baggable extends MorphPivot
{
    protected $table = 'baggables';
    public function baggable()
    {
        return $this->morphTo();
    }
}
