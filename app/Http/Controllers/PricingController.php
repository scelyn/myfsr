<?php

namespace App\Http\Controllers;

use App\Services\PricingService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PricingController extends Controller
{
    protected PricingService $pricingService;

    public function __construct(PricingService $pricingService)
    {
        $this->pricingService = $pricingService;
    }

    /**
     * Display the daily pricing form
     */
    public function daily(Request $request)
    {
        $date = $request->input('date', Carbon::today()->format('Y-m-d'));
        
        $products = $this->pricingService->getProductsForPricing($date);

        return view('pricing.daily', compact('products', 'date'));
    }

    /**
     * Store finalized prices
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'prices' => 'required|array',
            'prices.*.harga_beli' => 'required|numeric|min:0',
            'prices.*.harga_jual' => 'required|numeric|min:0|gte:prices.*.harga_beli',
        ], [
            'prices.*.harga_jual.gte' => 'Harga jual tidak boleh lebih kecil dari harga beli.',
        ]);

        try {
            $this->pricingService->finalizeDailyPricing($request->all());

            return redirect()->route('pricing.daily', ['date' => $request->date])
                ->with('success', 'Harga berhasil difinalisasi. Semua transaksi dan invoice telah diperbarui.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Finalisasi Harga Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            return back()->with('error', 'Terjadi kesalahan sistem saat menyimpan finalisasi harga. Silakan coba lagi atau hubungi administrator.');
        }
    }
}
