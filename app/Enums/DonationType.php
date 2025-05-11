<?php

namespace App\Enums;

enum DonationType: string
{
    case ONE_TIME = 'one-time';
    case MONTHLY = 'monthly';

    public static function getLabel(self $type): string
    {
        return match ($type) {
            self::ONE_TIME => 'One-Time',
            self::MONTHLY => 'Monthly',
        };
    }
}
