<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Public Signed Routes
Route::get('/invoices/{invoice}/pdf', [\App\Http\Controllers\InvoiceController::class, 'pdf'])
    ->name('invoices.pdf')
    ->middleware('signed');



Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Master Data Module
    Route::resource('products', \App\Http\Controllers\ProductController::class);
    Route::resource('customers', \App\Http\Controllers\CustomerController::class);
    Route::get('/api/customers/{customer}/piutang', [\App\Http\Controllers\CustomerController::class, 'getPiutang'])->name('api.customers.piutang');

    // Order Module
    Route::resource('orders', \App\Http\Controllers\OrderController::class);

    // Reporting Module
    Route::get('/reports/supplier', [\App\Http\Controllers\ReportController::class, 'supplierRekap'])->name('reports.supplier');
    Route::get('/reports/supplier/print', [\App\Http\Controllers\ReportController::class, 'printSupplierRekap'])->name('reports.supplier.print');
    Route::get('/reports/transactions', [\App\Http\Controllers\ReportController::class, 'transactions'])->name('reports.transactions');

    // Pricing Module
    Route::get('/pricing/daily', [\App\Http\Controllers\PricingController::class, 'daily'])->name('pricing.daily');
    Route::post('/pricing/daily', [\App\Http\Controllers\PricingController::class, 'store'])->name('pricing.store');

    // Financial Module
    Route::get('/invoices', [\App\Http\Controllers\InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/{invoice}', [\App\Http\Controllers\InvoiceController::class, 'show'])->name('invoices.show');
    Route::get('/payments/create', [\App\Http\Controllers\CustomerPaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments', [\App\Http\Controllers\CustomerPaymentController::class, 'store'])->name('payments.store');
});

require __DIR__.'/auth.php';
