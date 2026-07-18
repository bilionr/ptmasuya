<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Database\QueryException;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all(); 
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_product' => '',
            'nama_product' => '',
            'alamat_lengkap' => '',
            'provinsi' => '',
            'kota' => '',
            'kecamatan' => '',
            'kelurahan' => '',
            'kode_pos' => '',
        ]);
        product::create($validated);
        return redirect()->route('products.index')->with('success', 'product added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'kode_produk'   => '',
            'nama_produk'  => '',
            'harga'        => '',
            'stok'            => '',
        ]);

        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        // Nice UX: check for related transactions before attempting delete
        if ($product->transactionDetails()->exists()) {
            return redirect()->route('products.index')
                ->with('error', "Cannot delete '{$product->nama_produk}' because it still has related transactions. Please remove or reassign those transactions first.");
        }

        try {
            $product->delete();

            return redirect()->route('products.index')
                ->with('success', 'Product deleted successfully.');

        } catch (QueryException $e) {
            // Safety net: catches 1451 or any other FK violation (error code 23000)
            if ($e->getCode() === '23000') {
                return redirect()->route('products.index')
                    ->with('error', "Cannot delete '{$product->nama_produk}' because it is referenced by other records.");
            }

            // Re-throw anything unexpected so it's not silently swallowed
            throw $e;
        }
    }
}
