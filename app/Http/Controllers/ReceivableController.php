<?php

namespace App\Http\Controllers;

use App\Models\Receivable;
use App\Models\Customer;
use Illuminate\Http\Request;

class ReceivableController extends Controller
{
    public function index(Request $request)
    {
        $query = Receivable::with(['customer', 'invoice'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        $receivables = $query->paginate(15)->withQueryString();
        $customers = Customer::select('id', 'nama_toko')->orderBy('nama_toko')->get();
        
        $stats = \Illuminate\Support\Facades\Cache::remember('receivable_stats', 300, function () {
            return [
                'total_outstanding' => Receivable::where('status', '!=', 'paid')->sum('remaining_amount'),
                'total_overdue' => Receivable::where('status', '!=', 'paid')->where('due_date', '<', now())->sum('remaining_amount'),
                'count_unpaid' => Receivable::where('status', 'unpaid')->count(),
            ];
        });

        return view('receivables.index', compact('receivables', 'customers', 'stats'));
    }

    public function show(Receivable $receivable)
    {
        $receivable->load(['customer', 'invoice.items', 'payments']);
        
        return view('receivables.show', compact('receivable'));
    }
}
