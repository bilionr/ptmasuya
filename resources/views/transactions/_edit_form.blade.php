@csrf
<div class="p-6 space-y-6">
    <div class="grid md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Invoice Number</label>
            <input value="{{ $transaction->no_inv }}" readonly class="w-full bg-gray-100 border rounded-lg px-3 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Invoice Date</label>
            <input type="date" name="tgl_inv" value="{{ old('tgl_inv', $transaction->tgl_inv->format('Y-m-d')) }}" class="w-full border rounded-lg px-3 py-2">
        </div>
    </div>
    <div class="rounded-xl border border-gray-200 p-5">
        <h2 class="font-semibold text-gray-700 mb-4">Customer</h2>
        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm mb-2">Customer</label>
                <select id="customer" name="customer_id" class="w-full border rounded-lg px-3 py-2">
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" data-kode="{{ $customer->kode_customer }}" data-alamat="{{ $customer->alamat_lengkap }}" @selected($transaction->customer_id==$customer->id)>{{ $customer->kode_customer }} - {{ $customer->nama_customer }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm mb-2">Customer Code</label>
                <input id="kode_customer" readonly value="{{ $transaction->kode_customer }}" class="w-full bg-gray-100 border rounded-lg px-3 py-2"> 
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm mb-2">Address</label>
                <textarea id="alamat_lengkap" readonly rows="2" class="w-full bg-gray-100 border rounded-lg px-3 py-2">{{ $transaction->alamat_customer }}</textarea>
            </div>
        </div>
    </div>
    <div class="mt-8 border-t border-gray-200 pt-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-800">Detail Transaksi</h2>
            <button type="button" id="addRow" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm">+ Add Product</button>
        </div>
        <div class="overflow-x-auto border border-gray-200 rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 text-sm" id="detailTable">
                <thead class="bg-gray-100">
                    <tr class="text-gray-700">
                        <th class="px-3 py-3 text-left">Product</th>
                        <th class="px-3 py-3 text-center w-24">Qty</th>
                        <th class="px-3 py-3 text-right w-36">Price</th>
                        <th class="px-3 py-3 text-center w-24">Disc ke-1</th>
                        <th class="px-3 py-3 text-center w-24">Disc ke-2</th>
                        <th class="px-3 py-3 text-center w-24">Disc ke-3</th>
                        <th class="px-3 py-3 text-right w-36">Net Price</th>
                        <th class="px-3 py-3 text-right w-40">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaction->details as $detail)
                        <tr class="border-t">
                            <td class="p-2"><input readonly value="{{ $detail->kode_produk }} - {{ $detail->nama_produk }}" class="w-full bg-gray-100 border rounded-lg px-2 py-2"></td>
                            <td class="p-2"><input readonly value="{{ $detail->qty }}" class="w-full bg-gray-100 border rounded-lg px-2 py-2 text-center"></td>
                            <td class="p-2"><input readonly value="{{ number_format($detail->harga,2,'.','') }}" class="w-full bg-gray-100 border rounded-lg px-2 py-2 text-right"></td>
                            <td class="p-2"><input readonly value="{{ $detail->disc1 }}" class="w-full bg-gray-100 border rounded-lg px-2 py-2 text-center"></td>
                            <td class="p-2"><input readonly value="{{ $detail->disc2 }}" class="w-full bg-gray-100 border rounded-lg px-2 py-2 text-center"></td>
                            <td class="p-2"><input readonly value="{{ $detail->disc3 }}" class="w-full bg-gray-100 border rounded-lg px-2 py-2 text-center"></td>
                            <td class="p-2"><input readonly value="{{ number_format($detail->harga_net,2,'.','') }}" class="w-full bg-gray-100 border rounded-lg px-2 py-2 text-right"></td>
                            <td class="p-2"><input readonly value="{{ number_format($detail->jumlah,2,'.','') }}" class="w-full bg-gray-100 border rounded-lg px-2 py-2 text-right"></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="flex justify-end mt-6">
        <div class="w-80 bg-gray-50 rounded-xl border">
            <div class="flex justify-between px-5 py-4">
                <span class="font-medium text-gray-600">Grand Total</span>
                <span id="grandTotal" class="font-bold text-xl text-blue-700">Rp {{ number_format($transaction->total,0,',','.') }}</span>
            </div>
        </div>
    </div>
</div>
<div class="flex justify-end gap-3 mt-8 border-t pt-6">
    <a href="{{ route('transactions.index') }}" class="px-5 py-2 rounded-lg border border-gray-300 hover:bg-gray-100">Cancel</a>
    <button class="px-5 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white">Update Transaction</button>
</div>

<script>
    const customer = document.getElementById('customer');
    customer.addEventListener('change', function() {
        const option = this.selectedOptions[0];
        document.getElementById('kode_customer').value = option.dataset.kode ?? '';
        document.getElementById('alamat_lengkap').value = option.dataset.alamat ?? '';
    });
</script>