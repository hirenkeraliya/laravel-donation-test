<?php

namespace App\Enums;

enum PaymentType: string
{
    case AMEX = 'amex';
    case CARD = 'card';
    case BANK = 'bank';
    case CASH = 'cash';

    public static function getLabel(self $type): string
    {
        return match ($type) {
            self::AMEX => 'AMEX Card',
            self::CARD => 'Visa & Others',
            self::BANK => 'US Bank Account',
            self::CASH => 'Cash App Pay',
        };
    }

    public static function getProcessingFeePercentage(self $type): float
    {
        return match ($type) {
            self::AMEX => 3.5,
            self::CARD => 2.9,
            self::BANK => 0.8,
            self::CASH => 2.0,
        };
    }

    public static function getFlatFee(self $type): float
    {
        return match ($type) {
            self::AMEX, self::CARD => 0.30,
            self::BANK => 0.0,
            self::CASH => 0.25,
        };
    }
}
