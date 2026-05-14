<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Invoice;
use App\Models\Receivable;
use App\Models\CustomerPayment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $receivables = Receivable::where('status', 'unpaid')->get();
        $paymentService = app(\App\Services\PaymentService::class);

        foreach ($receivables as $receivable) {
            // Seed payments for 60% of unpaid receivables
            if (rand(1, 100) <= 60) {
                // Randomly decide if full payment or partial payment
                $isFull = rand(1, 100) <= 70;
                
                $amount = $isFull 
                    ? $receivable->remaining_amount 
                    : ($receivable->remaining_amount * (rand(30, 80) / 100)); // 30-80% partial

                $data = [
                    'receivable_id' => $receivable->id,
                    'amount' => $amount,
                    'payment_date' => now()->subDays(rand(1, 10)),
                    'payment_method' => rand(0, 1) ? 'cash' : 'transfer',
                    'notes' => 'Seeded payment',
                ];

                $paymentService->recordPayment($data);
            }
        }
    }
}
