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

    public function sortIndex(): int {
        return match ($this) {
            self::BLADE_PUTTER, self::MALLET_PUTTER => 0,
            self::LW => 1,
            self::SW => 2,
            self::GW => 3,
            self::PW => 4,
            self::NINE_IRON => 5,
            self::EIGHT_IRON => 6,
            self::SEVEN_IRON => 7,
            self::SIX_IRON => 8,
            self::FIVE_IRON => 9,
            self::FOUR_IRON => 10,
            self::THREE_IRON => 11,
            self::TWO_IRON => 12,
            self::ONE_IRON => 13,
            self::SEVEN_HYBRID => 14,
            self::SIX_HYBRID => 15,
            self::FIVE_HYBRID => 16,
            self::FOUR_HYBRID => 17,
            self::THREE_HYBRID => 18,
            self::TWO_HYBRID => 19,
            self::ONE_HYBRID => 20,
            self::NINE_WOOD => 21,
            self::SEVEN_WOOD => 22,
            self::FIVE_WOOD => 23,
            self::FOUR_WOOD => 24,
            self::THREE_WOOD => 25,
            self::TWO_WOOD => 26,
            self::ONE_WOOD => 27,
        };
    }
}
