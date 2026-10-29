<?php

namespace Tests\Unit;

use App\Support\BankAccountType;
use PHPUnit\Framework\TestCase;

class BankAccountTypeTest extends TestCase
{
    public function test_codes_and_labels_match_the_fnb_options(): void
    {
        $this->assertSame([
            0 => 'Public Recipient',
            1 => 'Current / Cheque',
            2 => 'Savings',
            3 => 'Transmission',
            4 => 'Bond',
            6 => 'Subscription Share',
            'D' => 'eWallet Pro',
            'S' => 'eWallet Send Money',
            'F' => 'FNB Card',
            'W' => 'WesBank',
        ], BankAccountType::OPTIONS);

        $this->assertSame('0', BankAccountType::normalize('Public Recipient'));
        $this->assertSame('1', BankAccountType::normalize('Cheque'));
        $this->assertSame('2', BankAccountType::normalize('Savings'));
        $this->assertSame('D', BankAccountType::normalize('eWallet Pro'));
        $this->assertSame('Current / Cheque', BankAccountType::label('1'));
        $this->assertSame('Business', BankAccountType::label('Business'));
    }
}
