<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Receivable;
use App\Models\CustomerPayment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentService extends BaseService
{
    /**
     * Record a customer payment and update invoice balance
     */
    public function recordPayment(array $data): CustomerPayment
    {
        return DB::transaction(function () use ($data) {
            $invoice = Invoice::lockForUpdate()->findOrFail($data['invoice_id']);
            
            if ($data['amount'] > $invoice->remaining_amount) {
                throw new \Exception('Jumlah pembayaran melebihi sisa tagihan.');
            }

            // 1. Create Payment Record
            $payment = CustomerPayment::create([
                'invoice_id' => $invoice->id,
                'customer_id' => $invoice->customer_id,
                'payment_number' => $this->generatePaymentNumber(),
                'amount' => $data['amount'],
                'payment_date' => $data['payment_date'] ?? now(),
                'payment_method' => $data['payment_method'] ?? 'cash',
                'reference_number' => $data['reference_number'] ?? null,
                'notes' => $data['notes'] ?? null,
            ]);

            // 2. Update Invoice Balance
            $invoice->paid_amount += $data['amount'];
            $invoice->remaining_amount -= $data['amount'];

            if ($invoice->remaining_amount <= 0) {
                $invoice->status = 'paid';
            } else {
                $invoice->status = 'partial';
            }

            $invoice->save();

            return $payment;
        });
    }

    /**
     * Generate unique payment number: PAY-YYYYMMDD-XXXX
     */
    private function generatePaymentNumber(): string
    {
        $date = now()->format('Ymd');
        $prefix = "PAY-{$date}-";
        
        $latest = CustomerPayment::where('payment_number', 'like', "{$prefix}%")
            ->orderBy('payment_number', 'desc')
            ->first();

        if (!$latest) {
            return "{$prefix}001";
        }

        $lastNumber = (int) substr($latest->payment_number, -3);
        $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

        return "{$prefix}{$newNumber}";
    }
}
