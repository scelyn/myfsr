<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Customer;
use Illuminate\Http\Request;

class ReceivableController extends Controller
{
    /**
     * Outstanding Invoice Monitor.
     *
     * Receivable data is derived DIRECTLY from invoices.
     * No separate receivable table is queried.
     */
    public function index(Request $request)
    {
        $query = Invoice::with('customer')
            ->whereIn('status', ['unpaid', 'partial'])
            ->where('remaining_amount', '>', 0);

        // ── Filters ──────────────────────────────────────────
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        $invoices = $query->orderBy('due_date', 'asc')
            ->paginate(15)
            ->withQueryString();

        $customers = Customer::select('id', 'nama_toko')->orderBy('nama_toko')->get();

        // ── Live stats (no cache — always reflects payment state) ──
        $stats = [
            'total_outstanding' => Invoice::whereIn('status', ['unpaid', 'partial'])
                ->where('remaining_amount', '>', 0)
                ->sum('remaining_amount'),

            'total_overdue' => Invoice::whereIn('status', ['unpaid', 'partial'])
                ->where('remaining_amount', '>', 0)
                ->where('due_date', '<', now()->toDateString())
                ->sum('remaining_amount'),

            'count_unpaid' => Invoice::whereIn('status', ['unpaid', 'partial'])
                ->where('remaining_amount', '>', 0)
                ->count(),
        ];

        return view('receivables.index', compact('invoices', 'customers', 'stats'));
    }

    /**
     * Receivable detail for a single invoice.
     *
     * Uses Invoice model binding — receivable IS the invoice.
     */
    public function show(Invoice $invoice)
    {
        $invoice->load(['customer', 'order.items.product', 'payments']);

        return view('receivables.show', compact('invoice'));
    }
}
