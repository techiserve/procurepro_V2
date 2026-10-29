<?php

namespace App\Support;

class BankAccountType
{
    public const OPTIONS = [
        '0' => 'Public Recipient',
        '1' => 'Current / Cheque',
        '2' => 'Savings',
        '3' => 'Transmission',
        '4' => 'Bond',
        '6' => 'Subscription Share',
        'D' => 'eWallet Pro',
        'S' => 'eWallet Send Money',
        'F' => 'FNB Card',
        'W' => 'WesBank',
    ];

    public static function code(?string $value): ?string
    {
        $value = trim((string) $value);
        if ($value === '') {
            return null;
        }

        $code = strtoupper($value);
        if (array_key_exists($code, self::OPTIONS)) {
            return $code;
        }

        return [
            'public recipient' => '0',
            'current' => '1',
            'cheque' => '1',
            'checking' => '1',
            'current / cheque' => '1',
            'savings' => '2',
            'saving' => '2',
            'transmission' => '3',
            'bond' => '4',
            'subscription share' => '6',
            'ewallet pro' => 'D',
            'ewallet send money' => 'S',
            'fnb card' => 'F',
            'wesbank' => 'W',
        ][strtolower($value)] ?? null;
    }

    public static function normalize(?string $value): ?string
    {
        $value = trim((string) $value);
        return $value === '' ? null : (self::code($value) ?? $value);
    }

    public static function label(?string $value): string
    {
        $code = self::code($value);
        return $code === null ? (string) $value : self::OPTIONS[$code];
    }
}
