<?php

namespace App\Enums;

enum SwingType: string
{
    case TWENTY_FIVE = '25%';
    case THIRTY_THREE = '33%';
    case FIFTY = '50%';
    case SIXTY_SIX = '66%';
    case SEVENTY_FIVE = '75%';
    case ONE_HUNDRED = '100%';

    public static function toArray(): array
    {
        return array_column(SwingType::cases(), 'value');
    }

}
