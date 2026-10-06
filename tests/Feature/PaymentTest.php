<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_payment_number_generation_skips_existing_numbers(): void
    {
        $customer = Customer::create([
            'name' => 'Test Customer',
            'email' => 'customer@example.com',
            'phone' => '1234567890',
            'status' => 'Active',
        ]);

        $monthPrefix = now()->format('Ym');
        $existingNumber = 'PAY-' . $monthPrefix . '-00002';

        Payment::create([
            'payment_number' => $existingNumber,
            'customer_id' => $customer->id,
            'project_id' => null,
            'payment_date' => now()->toDateString(),
            'amount' => 100.00,
            'payment_mode' => 'Cash',
            'reference_number' => 'REF-001',
            'notes' => 'Initial payment',
        ]);

        $generatedNumber = Payment::generateNumber();

        $this->assertNotSame($existingNumber, $generatedNumber);
        $this->assertMatchesRegularExpression('/^PAY-\d{6}-\d{5}$/', $generatedNumber);
    }
}
