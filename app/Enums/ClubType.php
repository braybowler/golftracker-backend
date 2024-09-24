<?php

namespace App\Enums;

enum ClubType: string
{
    case LW = 'LW';
    case SW = 'SW';
    case GW = 'GW';
    case PW = 'PW';
    case NINE_IRON = '9i';
    case EIGHT_IRON = '8i';
    case SEVEN_IRON = '7i';
    case SIX_IRON = '6i';
    case FIVE_IRON = '5i';
    case FOUR_IRON = '4i';
    case THREE_IRON = '3i';
    case TWO_IRON = '2i';
    case ONE_IRON = '1i';
    case SEVEN_HYBRID = '7h';
    case SIX_HYBRID = '6h';
    case FIVE_HYBRID = '5h';
    case FOUR_HYBRID = '4h';
    case THREE_HYBRID = '3h';
    case TWO_HYBRID = '2h';
    case ONE_HYBRID = '1h';
    case NINE_WOOD = '9w';
    case SEVEN_WOOD = '7w';
    case FIVE_WOOD = '5w';
    case FOUR_WOOD = '4w';
    case THREE_WOOD = '3w';
    case TWO_WOOD = '2w';
    case ONE_WOOD = '1w';
    case BLADE_PUTTER = 'Blade';
    case MALLET_PUTTER = 'Mallet';

    public static function toArray(): array
    {
        return array_column(ClubType::cases(), 'value');
    }
}
