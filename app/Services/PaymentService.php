<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Customer;
use App\Models\CustomerPayment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentService extends BaseService
{
    /**
     * Record a customer payment using FIFO Smart Allocation
     */
    public function recordPayment(array $data)
    {
        return DB::transaction(function () use ($data) {
            // Retrieve the customer from the submitted invoice_id
            $sourceInvoice = Invoice::findOrFail($data['invoice_id']);
            $customerId = $sourceInvoice->customer_id;

            $amountToDistribute = (float) $data['amount'];
            
            // Validate against total outstanding balance to prevent overpayment
            $totalOutstanding = Invoice::where('customer_id', $customerId)
                ->where('status', '!=', 'paid')
                ->sum('remaining_amount');

            if ($amountToDistribute > $totalOutstanding) {
                throw new \Exception('Jumlah pembayaran melebihi total seluruh sisa tagihan customer.');
            }

            // Ambil semua invoice customer yang belum lunas
            $unpaidInvoices = Invoice::where('customer_id', $customerId)
                ->where('status', '!=', 'paid')
                ->orderBy('invoice_date', 'asc')
                ->orderBy('id', 'asc')
                ->lockForUpdate()
                ->get();

            $paymentsCreated = [];

            // Loop pembayaran (FIFO)
            foreach ($unpaidInvoices as $invoice) {
                if ($amountToDistribute <= 0) {
                    break; // Stop if no money left
                }

                $payAmount = min($amountToDistribute, $invoice->remaining_amount);

                // 1. Create Payment Record specific to this invoice
                $paymentsCreated[] = CustomerPayment::create([
                    'invoice_id' => $invoice->id,
                    'customer_id' => $customerId,
                    'payment_number' => $this->generatePaymentNumber(),
                    'amount' => $payAmount,
                    'payment_date' => $data['payment_date'] ?? now(),
                    'payment_method' => $data['payment_method'] ?? 'cash',
                    'reference_number' => $data['reference_number'] ?? null,
                    'notes' => $data['notes'] ?? null,
                ]);

                // 2. Update Invoice Balance
                $invoice->paid_amount += $payAmount;
                $invoice->remaining_amount -= $payAmount;

                if ($invoice->remaining_amount <= 0) {
                    $invoice->status = 'paid';
                } else {
                    $invoice->status = 'partial';
                }

                $invoice->save();

                // Kurangi sisa uang yang didistribusikan
                $amountToDistribute -= $payAmount;
            }

            // Update otomatis jika semua lunas
            $newOutstanding = Invoice::where('customer_id', $customerId)
                ->where('status', '!=', 'paid')
                ->sum('remaining_amount');

            if ($newOutstanding == 0) {
                Invoice::where('customer_id', $customerId)
                    ->where('status', '!=', 'paid')
                    ->update(['status' => 'paid']);
            }

            \Illuminate\Support\Facades\Cache::forget('dashboard_data');
            \Illuminate\Support\Facades\Cache::forget('transactions_summary');
            \Illuminate\Support\Facades\Cache::forget('receivable_stats');

            return $paymentsCreated;
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
