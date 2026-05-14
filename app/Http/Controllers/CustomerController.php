<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use App\Services\CustomerService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    protected $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['search']);
        $customers = $this->customerService->getPaginated($filters);

        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerRequest $request)
    {
        $this->customerService->createCustomer($request->validated());

        return redirect()->route('customers.index')
            ->with('success', 'Data customer berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        // Eager load orders, payments, and receivables for detail page
        $customer->load([
            'orders' => fn ($q) => $q->with('invoice')->latest()->limit(10),
            'receivables' => fn ($q) => $q->with('invoice')->orderBy('due_date'),
            'customerPayments' => fn ($q) => $q->latest()->limit(10),
        ]);

        return view('customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerRequest $request, Customer $customer)
    {
        $this->customerService->updateCustomer($customer, $request->validated());

        return redirect()->route('customers.show', $customer)
            ->with('success', 'Data customer berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $this->customerService->deleteCustomer($customer);

        return redirect()->route('customers.index')
            ->with('success', 'Data customer berhasil dihapus.');
    }

    /**
     * Get active piutang for a customer (API)
     */
    public function getPiutang(Customer $customer)
    {
        $baseQuery = \App\Models\Invoice::where('customer_id', $customer->id)
            ->where('status', '!=', 'paid');
            
        $totalPiutang = $baseQuery->sum('remaining_amount');
        $unpaidCount = $baseQuery->count();
        
        $invoices = $baseQuery->select('invoice_number', 'remaining_amount', 'invoice_date')->get();
        
        $histori = $invoices->map(function($inv) {
            return [
                'invoice_number' => $inv->invoice_number,
                'remaining_amount' => $inv->remaining_amount,
                'date' => \Carbon\Carbon::parse($inv->invoice_date)->format('d M Y')
            ];
        });

        return response()->json([
            'total_piutang' => $totalPiutang,
            'unpaid_count' => $unpaidCount,
            'histori' => $histori
        ]);
    }
}
