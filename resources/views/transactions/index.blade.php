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
    <div class="w-full flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6 mt-2 px-2">
        <div>
            <h3 class="text-xl font-bold text-gray-900">Manage your Invoices</h3>
            <p class="text-sm text-gray-500">Overview of your system invoices and transactions.</p>
        </div>
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full md:w-auto ml-auto">
            <div class="w-full sm:w-72 relative">
                <input type="text" name="search" class="w-full h-10 pl-3 pr-10 py-2 bg-white placeholder-gray-400 text-gray-700 text-sm border border-gray-300 rounded-lg transition-all focus:outline-none focus:border-gray-500 focus:ring-1 focus:ring-gray-500 shadow-sm" placeholder="Search for invoice..." />
                <button class="absolute h-8 w-8 right-1 top-1 flex items-center justify-center bg-gray-50 hover:bg-gray-100 rounded-md transition-colors" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 text-gray-500"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
                </button>
            </div>
            <a href="{{ route('transactions.create') }}" class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium h-10 px-4 rounded-lg shadow-sm transition whitespace-nowrap">+ Add Transaction</a>
        </div>
    </div>
 
    <!-- Table Wrapper Container -->
    <div class="relative flex flex-col w-full h-full overflow-x-auto bg-white shadow-sm rounded-xl border border-gray-200">
        <table class="w-full text-left table-auto min-w-max">
            <thead class="text-xs font-semibold uppercase text-gray-600 bg-gray-50 border-b border-gray-200">
                <tr>
                    <th scope="col" class="p-4">Invoice Number</th>
                    <th scope="col" class="p-4">Customer</th>
                    <th scope="col" class="p-4">Amount</th>
                    <th scope="col" class="p-4">Issued</th>
                    <th scope="col" class="p-4 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($transactions as $transaction)
                    <tr class="bg-white hover:bg-gray-50 transition-colors">
                        <td class="p-4 font-semibold text-sm text-gray-900">
                            {{ $transaction->no_inv }}
                        </td>
                        <td class="p-4 text-sm text-gray-700">
                            {{ $transaction->customer->nama_customer ?? 'Unknown Customer' }}
                        </td>
                        <td class="p-4 text-sm font-medium text-gray-900">
                            Rp. {{ number_format($transaction->total) }}
                        </td>
                        <td class="p-4 text-sm text-gray-600">
                            {{ $transaction->created_at->format('Y-m-d') }}
                        </td>
                        <td class="p-4 text-center">
                            <div class="flex items-center justify-center space-x-3">
                                <form action="{{ route('transactions.destroy', $transaction->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Delete this transaction? Stock will be restored.')"
                                    class="inline">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="text-gray-500 hover:text-red-600 transition-colors"
                                        title="Delete Invoice">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24"
                                            fill="currentColor"
                                            class="w-5 h-5">

                                            <path d="M3.375 3C2.339 3 1.5 3.84 1.5 4.875v.75c0 1.036.84 1.875 1.875 1.875h17.25c1.035 0 1.875-.84 1.875-1.875v-.75C22.5 3.839 21.66 3 20.625 3H3.375Z"/>
                                            <path fill-rule="evenodd"
                                                d="m3.087 9 .54 9.176A3 3 0 0 0 6.62 21h10.757a3 3 0 0 0 2.995-2.824L20.913 9H3.087ZM12 10.5a.75.75 0 0 1 .75.75v4.94l1.72-1.72a.75.75 0 1 1 1.06 1.06l-3 3a.75.75 0 0 1-1.06 0l-3-3a.75.75 0 1 1 1.06-1.06l1.72 1.72v-4.94a.75.75 0 0 1 .75-.75Z"
                                                clip-rule="evenodd"/>

                                        </svg>

                                    </button>

                                </form>
                                <!-- View/Print Action (Document Icon) -->
                                <a href="{{ route('transactions.edit', $transaction->id) }}" class="text-gray-500 hover:text-blue-600 transition-colors" title="Edit Details">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                        <path d="M7.5 3.375c0-1.036.84-1.875 1.875-1.875h.375a3.75 3.75 0 0 1 3.75 3.75v1.875C13.5 8.161 14.34 9 15.375 9h1.875A3.75 3.75 0 0 1 21 12.75v3.375C21 17.16 20.16 18 19.125 18h-9.75A1.875 1.875 0 0 1 7.5 16.125V3.375Z" />
                                        <path d="M15 5.25a5.23 5.23 0 0 0-1.279-3.434 9.768 9.768 0 0 1 6.963 6.963A5.23 5.23 0 0 0 17.25 7.5h-1.875A.375.375 0 0 1 15 7.125V5.25ZM4.875 6H6v10.125A3.375 3.375 0 0 0 9.375 19.5H16.5v1.125c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V7.875C3 6.839 3.84 6 4.875 6Z" />
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-sm text-gray-400 font-medium">
                            No invoices found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</x-layout>