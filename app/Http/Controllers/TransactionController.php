<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Customer;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::all(); 
        return view('transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::orderBy('nama_produk')->get();
        $customers = Customer::orderBy('nama_customer')->get();
        return view('transactions.create', compact('products', 'customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'tgl_inv' => 'required|date',

            'details' => 'required|array|min:1',
            'details.*.product_id' => 'required|exists:products,id',
            'details.*.kode_produk' => 'required|string',
            'details.*.nama_produk' => 'required|string',
            'details.*.qty' => 'required|integer|min:1',
            'details.*.harga' => 'required|numeric|min:0',
            'details.*.disc1' => 'nullable|numeric|min:0',
            'details.*.disc2' => 'nullable|numeric|min:0',
            'details.*.disc3' => 'nullable|numeric|min:0',
            'details.*.harga_net' => 'required|numeric|min:0',
            'details.*.jumlah' => 'required|numeric|min:0',
        ]);
        DB::transaction(function () use ($validated) {

            // Generate invoice number
            $noInv = Transaction::generateInvoiceNumber();

            // Get customer snapshot
            $customer = \App\Models\Customer::findOrFail($validated['customer_id']);

            // Create transaction
            $transaction = Transaction::create([
                'no_inv' => $noInv,
                'customer_id' => $customer->id,
                'kode_customer' => $customer->kode_customer,
                'nama_customer' => $customer->nama_customer,
                'alamat_customer' => $customer->alamat_customer,
                'tgl_inv' => $validated['tgl_inv'],
                'total' => 0,
            ]);

            $total = 0;

            foreach ($validated['details'] as $detail) {

                $product = Product::lockForUpdate()->findOrFail($detail['product_id']);

                if ($product->stok < $detail['qty']) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'details' => "Stock for {$product->nama_produk} is insufficient. Available: {$product->stok}, requested: {$detail['qty']}."
                    ]);
                }

                $transaction->details()->create([
                    'no_inv' => $noInv,
                    'product_id' => $detail['product_id'],
                    'kode_produk' => $detail['kode_produk'],
                    'nama_produk' => $detail['nama_produk'],
                    'qty' => $detail['qty'],
                    'harga' => $detail['harga'],
                    'disc1' => $detail['disc1'] ?? 0,
                    'disc2' => $detail['disc2'] ?? 0,
                    'disc3' => $detail['disc3'] ?? 0,
                    'harga_net' => $detail['harga_net'],
                    'jumlah' => $detail['jumlah'],
                ]);
                
                $product->decrement('stok', $detail['qty']);

                $total += $detail['jumlah'];
            }

            $transaction->update([
                'total' => $total
            ]);

        });
        return redirect()->route('transactions.index')->with('success', 'Transaction added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $transaction = Transaction::with('details')->findOrFail($id);

        $customers = Customer::orderBy('nama_customer')->get();

        return view('transactions.edit', compact(
            'transaction',
            'customers'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'tgl_inv' => 'required|date',
        ]);

        $customer = Customer::findOrFail($validated['customer_id']);

        $transaction->update([
            'customer_id'      => $customer->id,
            'kode_customer'    => $customer->kode_customer,
            'nama_customer'    => $customer->nama_customer,
            'alamat_customer'  => $customer->alamat_lengkap,
            'tgl_inv'          => $validated['tgl_inv'],
        ]);

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaction updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::transaction(function () use ($id) {

            $transaction = Transaction::with('details')->findOrFail($id);

            foreach ($transaction->details as $detail) {

                $detail->product->increment('stok', $detail->qty);

            }

            $transaction->delete();

        });

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaction deleted successfully.');
    }
}
