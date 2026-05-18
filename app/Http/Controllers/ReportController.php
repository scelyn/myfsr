<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\Customer;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    protected ReportService $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function supplierRekap(Request $request)
    {
        // Default to today if no date provided
        $date = $request->input('date', Carbon::today()->format('Y-m-d'));
        
        $rekaps = $this->reportService->getSupplierRekap($date);
        $summary = $this->reportService->getDailySummary($date, $rekaps);

        return view('reports.supplier', compact('rekaps', 'summary', 'date'));
    }
    public function printSupplierRekap(Request $request)
    {
        $date = $request->input('date', Carbon::today()->format('Y-m-d'));
        $rekaps = $this->reportService->getSupplierRekap($date);
        $summary = $this->reportService->getDailySummary($date, $rekaps);

        if ($rekaps->isEmpty()) {
            return back()->with('error', 'Tidak ada data pesanan untuk tanggal ini.');
        }

        $pdf = Pdf::loadView('reports.supplier_pdf', compact('rekaps', 'summary', 'date'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('Rekap-Supplier-' . $date . '.pdf');
    }

    public function transactions(Request $request)
    {
        // ── Resolve filter type & date range ──────────────────────────────────
        $filterType = $request->input('filter_type', 'month');
        $now        = Carbon::now();

        switch ($filterType) {
            case 'today':
                $startDate = $now->copy()->startOfDay();
                $endDate   = $now->copy()->endOfDay();
                break;

            case 'week':
                $startDate = $now->copy()->startOfWeek(Carbon::MONDAY);
                $endDate   = $now->copy()->endOfWeek(Carbon::SUNDAY)->endOfDay();
                break;

            case 'month':
                $startDate = $now->copy()->startOfMonth();
                $endDate   = $now->copy()->endOfMonth()->endOfDay();
                break;

            case 'year':
                $startDate = $now->copy()->startOfYear();
                $endDate   = $now->copy()->endOfYear()->endOfDay();
                break;

            case 'custom':
                $startDate = $request->filled('start_date')
                    ? Carbon::parse($request->input('start_date'))->startOfDay()
                    : $now->copy()->startOfMonth();
                $endDate = $request->filled('end_date')
                    ? Carbon::parse($request->input('end_date'))->endOfDay()
                    : $now->copy()->endOfDay();
                break;

            default:
                $startDate = $now->copy()->startOfMonth();
                $endDate   = $now->copy()->endOfMonth()->endOfDay();
                break;
        }

        // ── Build base query on Orders (filtered by order_date) ───────────────
        $query = Order::with(['customer', 'items', 'invoice'])
            ->whereBetween('order_date', [$startDate->toDateString(), $endDate->toDateString()]);

        // ── Fetch filtered orders ─────────────────────────────────────────────
        $orders = $query->latest('order_date')->get();

        // ── Summary cards use the SAME filtered dataset ───────────────────────
        $totalOmzet  = $orders->sum(fn ($o) => $o->invoice?->total_amount ?? 0);
        $totalOrders = $orders->count();
        $totalQty    = $orders->sum(fn ($o) => $o->items->sum('quantity'));

        return view('reports.transactions', compact(
            'orders',
            'totalOmzet',
            'totalOrders',
            'totalQty',
            'filterType',
            'startDate',
            'endDate',
        ));
    }
}
