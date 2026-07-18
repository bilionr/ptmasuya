@csrf

<div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

    <div class="sm:col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-1">Kode Customer *</label>
        <input type="text" name="kode_customer" required pattern="[A-Za-z0-9]+"
               title="Alphanumeric only"
               value="{{ old('kode_customer', $customer->kode_customer ?? '') }}"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        @error('kode_customer') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="sm:col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Customer *</label>
        <input type="text" name="nama_customer" required
               value="{{ old('nama_customer', $customer->nama_customer ?? '') }}"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        @error('nama_customer') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="sm:col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap *</label>
        <textarea name="alamat_lengkap" required rows="2"
                  class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('alamat_lengkap', $customer->alamat_lengkap ?? '') }}</textarea>
        @error('alamat_lengkap') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Provinsi *</label>
        <input type="text" name="provinsi" required
               value="{{ old('provinsi', $customer->provinsi ?? '') }}"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        @error('provinsi') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Kota *</label>
        <input type="text" name="kota" required
               value="{{ old('kota', $customer->kota ?? '') }}"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        @error('kota') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Kecamatan *</label>
        <input type="text" name="kecamatan" required
               value="{{ old('kecamatan', $customer->kecamatan ?? '') }}"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        @error('kecamatan') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Kelurahan *</label>
        <input type="text" name="kelurahan" required
               value="{{ old('kelurahan', $customer->kelurahan ?? '') }}"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        @error('kelurahan') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Kode Pos *</label>
        <input type="text" name="kode_pos" required maxlength="10"
               value="{{ old('kode_pos', $customer->kode_pos ?? '') }}"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        @error('kode_pos') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

</div>