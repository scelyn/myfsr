<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::latest();

        if ($request->filled('search')) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(10)->withQueryString();

        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(ProductRequest $request)
    {
        Product::create($request->validated());

        return redirect()->route('products.index')
            ->with('success', 'Barang berhasil ditambahkan ke Master Data.');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        return redirect()->route('products.index')
            ->with('success', 'Data barang berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage (soft-delete).
     * Blocks deletion if product has been used in any transaction.
     */
    public function destroy(Product $product)
    {
        // ── Guard: block if product is used in any order item ──
        if ($product->orderItems()->exists()) {
            return redirect()->route('products.index')
                ->with('error', "Produk \"{$product->nama_barang}\" tidak dapat dihapus karena masih digunakan dalam transaksi.");
        }

        try {
            $product->delete();

            return redirect()->route('products.index')
                ->with('success', "Produk \"{$product->nama_barang}\" berhasil dihapus.");
        } catch (\Exception $e) {
            return redirect()->route('products.index')
                ->with('error', 'Gagal menghapus produk. Silakan coba lagi atau hubungi administrator.');
        }
    }
}
