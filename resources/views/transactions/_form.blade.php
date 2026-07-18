@csrf
<div class="p-6 space-y-6">
    <div class="grid md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Invoice Number</label>
            <input value="Auto Generated" readonly class="w-full bg-gray-100 border rounded-lg px-3 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Invoice Date</label>
            <input type="date" name="tgl_inv" value="{{ old('tgl_inv', date('Y-m-d')) }}" class="w-full border rounded-lg px-3 py-2">
        </div>
    </div>

    <div class="rounded-xl border border-gray-200 p-5">
        <h2 class="font-semibold text-gray-700 mb-4">Customer</h2>
        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm mb-2">Customer</label>
                <select id="customer" name="customer_id" class="w-full border rounded-lg px-3 py-2">
                    <option value="">Select Customer</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" data-kode="{{ $customer->kode_customer }}" data-nama="{{ $customer->nama_customer }}" data-alamat="{{ $customer->alamat_lengkap }}">
                            {{ $customer->kode_customer }} - {{ $customer->nama_customer }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm mb-2">Customer Code</label>
                <input id="kode_customer" readonly class="w-full bg-gray-100 border rounded-lg px-3 py-2">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm mb-2">Address</label>
                <textarea id="alamat_lengkap" readonly rows="2" class="w-full bg-gray-100 border rounded-lg px-3 py-2"></textarea>
            </div>
        </div>
    </div>

    @error('details')
        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-700">
            {{ $message }}
        </div>
    @enderror
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
                        <th class="px-3 py-3 text-center w-16"></th>
                    </tr>
                </thead>
                <tbody id="detailBody"></tbody>
            </table>
        </div>
    </div>

    <div class="flex justify-end mt-6">
        <div class="w-80 bg-gray-50 rounded-xl border">
            <div class="flex justify-between px-5 py-4">
                <span class="font-medium text-gray-600">Grand Total</span>
                <span id="grandTotal" class="font-bold text-xl text-blue-700">Rp 0</span>
            </div>
        </div>
    </div>
</div>

<div class="flex justify-end gap-3 mt-8 border-t pt-6">
    <a href="{{ route('transactions.index') }}" class="px-5 py-2 rounded-lg border border-gray-300 hover:bg-gray-100">Cancel</a>
    <button class="px-5 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white">Save Transaction</button>
</div>

<script>
    const customer = document.getElementById('customer');
    customer.addEventListener('change', function() {
        const option = this.selectedOptions[0];
        document.getElementById('kode_customer').value = option.dataset.kode ?? '';
        document.getElementById('alamat_lengkap').value = option.dataset.alamat ?? '';
    });
</script>

@php
    $jsProducts = $products->map(fn ($p) => [
        'id'    => $p->id,
        'kode'  => $p->kode_produk,
        'nama'  => $p->nama_produk,
        'harga' => $p->harga,
    ]);
@endphp

<script>
    let rowIndex = 0;
    const products = @json($jsProducts);

    function updateGrandTotal() {
        let total = 0;
        document.querySelectorAll('.jumlah').forEach(item => { total += Number(item.value || 0); });
        document.getElementById('grandTotal').innerHTML = 'Rp ' + total.toLocaleString('id-ID');
    }

    function productOptions() {
        let html = '<option value="">Choose Product</option>';
        products.forEach(product => {
            html += `<option value="${product.id}" data-kode="${product.kode}" data-nama="${product.nama}" data-harga="${product.harga}">${product.kode} - ${product.nama}</option>`;
        });
        return html;
    }

    function addRow() {
        let html = `
        <tr class="border-t">
            <td class="p-2">
                <select name="details[${rowIndex}][product_id]" class="product w-full border rounded-lg px-2 py-2">${productOptions()}</select>
                <input type="hidden" name="details[${rowIndex}][kode_produk]" class="kode">
                <input type="hidden" name="details[${rowIndex}][nama_produk]" class="nama">
            </td>
            <td class="p-2"><input type="number" min="1" value="1" name="details[${rowIndex}][qty]" class="qty w-full border rounded-lg px-2 py-2 text-center"></td>
            <td class="p-2"><input type="number" step="0.01" name="details[${rowIndex}][harga]" class="harga w-full border rounded-lg px-2 py-2 text-right"></td>
            <td class="p-2"><input type="number" step="0.01" value="0" name="details[${rowIndex}][disc1]" class="disc1 w-full border rounded-lg px-2 py-2 text-center"></td>
            <td class="p-2"><input type="number" step="0.01" value="0" name="details[${rowIndex}][disc2]" class="disc2 w-full border rounded-lg px-2 py-2 text-center"></td>
            <td class="p-2"><input type="number" step="0.01" value="0" name="details[${rowIndex}][disc3]" class="disc3 w-full border rounded-lg px-2 py-2 text-center"></td>
            <td class="p-2"><input readonly name="details[${rowIndex}][harga_net]" class="harga_net w-full bg-gray-100 border rounded-lg px-2 py-2 text-right"></td>
            <td class="p-2"><input readonly name="details[${rowIndex}][jumlah]" class="jumlah w-full bg-gray-100 border rounded-lg px-2 py-2 text-right"></td>
            <td class="text-center"><button type="button" class="remove text-red-600 hover:text-red-800 font-bold">✕</button></td>
        </tr>`;
        document.querySelector('#detailBody').insertAdjacentHTML('beforeend', html);
        rowIndex++;
    }

    function calculate(row) {
        let qty = parseFloat(row.querySelector('.qty').value) || 0;
        let harga = parseFloat(row.querySelector('.harga').value) || 0;
        let d1 = parseFloat(row.querySelector('.disc1').value) || 0;
        let d2 = parseFloat(row.querySelector('.disc2').value) || 0;
        let d3 = parseFloat(row.querySelector('.disc3').value) || 0;
        let net = harga;
        net -= net * (d1 / 100);
        net -= net * (d2 / 100);
        net -= net * (d3 / 100);
        row.querySelector('.harga_net').value = net.toFixed(2);
        row.querySelector('.jumlah').value = (qty * net).toFixed(2);
        updateGrandTotal();
    }

    document.getElementById('addRow').onclick = addRow;

    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('product')) {
            let row = e.target.closest('tr');
            let option = e.target.selectedOptions[0];
            row.querySelector('.harga').value = option.dataset.harga ?? 0;
            row.querySelector('.kode').value = option.dataset.kode ?? '';
            row.querySelector('.nama').value = option.dataset.nama ?? '';
            calculate(row);
        }
    });

    document.addEventListener('input', function(e) {
        if (e.target.matches('.qty, .harga, .disc1, .disc2, .disc3')) {
            calculate(e.target.closest('tr'));
        }
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove')) {
            e.target.closest('tr').remove();
            updateGrandTotal();
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            if (e.target.matches('input, select, textarea')) {
                e.preventDefault();
                let row = e.target.closest('tr');
                if (row) calculate(row);
                updateGrandTotal();
            }
        }
    });

    addRow();
</script>