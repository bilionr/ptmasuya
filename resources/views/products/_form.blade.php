@csrf

<div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

    <div class="sm:col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-1">Kode produk *</label>
        <input type="text" name="kode_produk" required pattern="[A-Za-z0-9]+"
               title="Alphanumeric only"
               value="{{ old('kode_produk', $product->kode_produk ?? '') }}"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        @error('kode_produk') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="sm:col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-1">Nama produk *</label>
        <input type="text" name="nama_produk" required
               value="{{ old('nama_produk', $product->nama_produk ?? '') }}"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        @error('nama_produk') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="sm:col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-1">Harga *</label>
        <textarea name="harga" required rows="2"
                  class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('harga', $product->harga ?? '') }}</textarea>
        @error('harga') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Stok *</label>
        <input type="text" name="stok" required
               value="{{ old('stok', $product->stok ?? '') }}"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        @error('stok') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
</div>