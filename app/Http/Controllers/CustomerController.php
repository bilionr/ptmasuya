<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Transaction;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all(); 
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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_customer'   => 'required|alpha_num|unique:customers,kode_customer',
            'nama_customer' => '',
            'alamat_lengkap' => '',
            'provinsi' => '',
            'kota' => '',
            'kecamatan' => '',
            'kelurahan' => '',
            'kode_pos' => '',
        ], [
        'kode_customer.unique' => 'Kode Customer sudah digunakan.']);
        Customer::create($validated);
        return redirect()->route('customers.index')->with('success', 'Customer added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer = Customer::findOrFail($id);
        return view('customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customer = Customer::findOrFail($id);
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'nama_customer'   => '',
            'alamat_lengkap'  => '',
            'provinsi'        => '',
            'kota'            => '',
            'kecamatan'       => '',
            'kelurahan'       => '',
            'kode_pos'        => '',
        ]);

        $customer->update($validated);

        return redirect()->route('customers.index')
            ->with('success', 'Customer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::findOrFail($id);
        // Nice UX: check for related transactions before attempting delete
        if ($customer->transactions()->exists()) {
            return redirect()->route('customers.index')
                ->with('error', "Cannot delete '{$customer->nama_customer}' because it still has related transactions. Please remove or reassign those transactions first.");
        }

        try {
            $customer->delete();

            return redirect()->route('customers.index')
                ->with('success', 'Customer deleted successfully.');

        } catch (QueryException $e) {
            // Safety net: catches 1451 or any other FK violation (error code 23000)
            if ($e->getCode() === '23000') {
                return redirect()->route('customers.index')
                    ->with('error', "Cannot delete '{$customer->nama_customer}' because it is referenced by other records.");
            }

            // Re-throw anything unexpected so it's not silently swallowed
            throw $e;
        }
    }
}
