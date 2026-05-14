<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
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
        $summary = $this->reportService->getDailySummary($date);

        return view('reports.supplier', compact('rekaps', 'summary', 'date'));
    }
    public function printSupplierRekap(Request $request)
    {
        $date = $request->input('date', Carbon::today()->format('Y-m-d'));
        $rekaps = $this->reportService->getSupplierRekap($date);
        $summary = $this->reportService->getDailySummary($date);

        if ($rekaps->isEmpty()) {
            return back()->with('error', 'Tidak ada data pesanan untuk tanggal ini.');
        }

        $pdf = Pdf::loadView('reports.supplier_pdf', compact('rekaps', 'summary', 'date'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('Rekap-Supplier-' . $date . '.pdf');
    }

    public function transactions(Request $request)
    {
        $query = Invoice::with(['customer', 'order']);
        
        if ($request->has('date') && $request->date != '') {
            $query->whereHas('order', function($q) use ($request) {
                $q->whereDate('order_date', $request->date);
            });
        }
        
        if ($request->has('customer_id') && $request->customer_id != '') {
            $query->where('customer_id', $request->customer_id);
        }
        
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('invoice_number', 'like', "%{$search}%");
        }
        
        $invoices = $query->latest('id')->paginate(15)->withQueryString();
        
        $summary = [
            'total_transaksi' => Invoice::count(),
            'total_omzet' => Invoice::sum('total_amount'),
            'total_piutang' => Invoice::sum('remaining_amount'),
            'total_lunas' => Invoice::where('status', 'paid')->count(),
        ];
        
        $customers = Customer::orderBy('nama_toko')->get();
        
        return view('reports.transactions', compact('invoices', 'summary', 'customers'));
    }
}
