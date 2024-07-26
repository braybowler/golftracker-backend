<?php

namespace App\Enums;

enum ClubCategory: string {
    case WEDGE = 'Wedge';
    case IRON = 'Iron';
    case HYBRID = 'Hybrid';
    case WOOD = 'Wood';
    case PUTTER = 'Putter';

    public static function toArray(): array
    {
        return array_column(ClubCategory::cases(), 'value');
    }
}
