<?php

namespace App\Http\Controllers;

use App\Models\Receivable;
use App\Models\CustomerPayment;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class CustomerPaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function store(Request $request)
    {
        $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'amount' => 'required|numeric|min:1',
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:cash,transfer',
            'reference_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ]);

        try {
            $this->paymentService->recordPayment($request->all());

            return redirect()->route('invoices.show', $request->invoice_id)
                ->with('success', 'Pembayaran berhasil dialokasikan secara otomatis.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }
}
