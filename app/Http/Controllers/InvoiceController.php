<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    /**
     * Display a listing of invoices.
     */
    public function index(Request $request)
    {
        $query = Invoice::with('customer')->latest('id');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('invoice_number', 'like', "%{$search}%")
                  ->orWhereHas('customer', function($q) use ($search) {
                      $q->where('nama_toko', 'like', "%{$search}%");
                  });
        }

        $invoices = $query->paginate(10)->withQueryString();

        return view('invoices.index', compact('invoices'));
    }

    /**
     * Display the specified invoice / note.
     */
    public function show(Invoice $invoice)
    {
        $invoice->load(['order.items.product', 'customer', 'payments']);
        
        $previous_tunggakan = Invoice::where('customer_id', $invoice->customer_id)
            ->where('id', '!=', $invoice->id)
            ->where('remaining_amount', '>', 0)
            ->sum('remaining_amount');

        return view('invoices.show', compact('invoice', 'previous_tunggakan'));
    }

    /**
     * Generate PDF for the invoice.
     */
    public function pdf(Invoice $invoice)
    {
        $invoice->load(['order.items.product', 'customer']);
        
        $previous_tunggakan = Invoice::where('customer_id', $invoice->customer_id)
            ->where('id', '!=', $invoice->id)
            ->where('remaining_amount', '>', 0)
            ->sum('remaining_amount');

        $pdf = Pdf::loadView('invoices.pdf', compact('invoice', 'previous_tunggakan'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream($invoice->invoice_number . '.pdf');
    }
}
