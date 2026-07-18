<x-layout>
    @if (session('success'))
        <div class="max-w-6xl mx-auto mt-4 px-4">
            <div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg px-4 py-3">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="max-w-6xl mx-auto mt-4 px-4">
            <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg px-4 py-3">
                {{ session('error') }}
            </div>
        </div>
    @endif
    
    <div class="max-w-6xl mx-auto mt-8 px-4">

        <div class="flex items-center justify-between mb-4">
            <h1 class="text-xl font-semibold text-gray-800">Customers</h1>
            <a href="{{ route('customers.create') }}"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg shadow-sm transition">
                + Add Customer
            </a>
        </div>

        <div class="relative overflow-x-auto bg-white shadow-sm rounded-lg border border-gray-200">
            <table class="w-full text-sm text-left text-gray-700">
                <thead class="text-xs uppercase text-gray-500 bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th scope="col" class="px-6 py-3 font-medium">Kode</th>
                        <th scope="col" class="px-6 py-3 font-medium">Nama</th>
                        <th scope="col" class="px-6 py-3 font-medium">Alamat</th>
                        <th scope="col" class="px-6 py-3 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                        <tr class="bg-white border-b border-gray-100 hover:bg-gray-50">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $customer->kode_customer }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $customer->nama_customer }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $customer->alamat_lengkap ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <a href="{{ route('customers.edit', $customer->id) }}"
                                   class="font-medium text-blue-600 hover:underline mr-3">Edit</a>
                                <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Delete this customer?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-medium text-red-600 hover:underline cursor-pointer">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-400">
                                No customers found in the database.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layout>