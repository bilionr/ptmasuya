{{-- products.index.blade.php --}}
<x-layout>
@if (session('success') || session('error'))
    <div class="max-w-6xl mx-auto mt-4 px-4">
        <div class="border text-sm rounded-lg px-4 py-3 {{ session('success') ? 'bg-green-50 border-green-200 text-green-700' : 'bg-red-50 border-red-200 text-red-700' }}">
            {{ session('success') ?? session('error') }}
        </div>
    </div>
@endif

    <div class="max-w-6xl mx-auto mt-8 px-4">
        <!-- Unified Header Layout Matching Transactions exactly -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Products</h3>
                <p class="text-sm text-gray-500">Overview of your inventory stock and product levels.</p>
            </div>
            <div class="flex items-center md:w-auto ml-auto">
                <a href="{{ route('products.create') }}" class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium h-10 px-4 rounded-lg shadow-sm transition whitespace-nowrap">+ Add Product</a>
            </div>
        </div>

        <!-- Table Container Set to rounded-xl to match Transactions exactly -->
        <div class="overflow-x-auto bg-white shadow-sm rounded-xl border border-gray-200">
            <table class="w-full text-left table-auto min-w-max">
                <thead class="text-xs font-semibold uppercase text-gray-600 bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="p-4 w-24 text-center">Image</th>
                        <th class="p-4">Product</th>
                        <th class="p-4 text-center w-28">Qty</th>
                        <th class="p-4">Price</th>
                        <th class="p-4 text-center w-36">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                    @forelse($products as $product)
                        <tr class="bg-white hover:bg-gray-50 transition-colors">
                            <td class="p-4 flex justify-center">
                                <img src="{{ $product->image ?? '/docs/images/products/apple-watch.png' }}" class="w-12 h-12 object-contain" alt="{{ $product->nama_produk }}">
                            </td>
                            <td class="p-4 font-semibold text-gray-900">{{ $product->nama_produk }}</td>
                            <td class="p-4">
                                <div class="flex items-center justify-center space-x-2">
                                    <button type="button" id="decrement-button-{{ $product->id }}" data-input-counter-decrement="counter-input-{{ $product->id }}" class="flex items-center justify-center text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 rounded-full h-6 w-6 transition-all focus:outline-none">
                                        <svg class="w-3 h-3 text-gray-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14"/></svg>
                                    </button>
                                    <input type="text" id="counter-input-{{ $product->id }}" name="products[{{ $product->id }}][stok]" data-input-counter class="w-10 text-center text-sm font-semibold text-gray-900 bg-transparent border-0 p-0 focus:ring-0 focus:outline-none" value="{{ $product->stok ?? 1 }}" required />
                                    <button type="button" id="increment-button-{{ $product->id }}" data-input-counter-increment="counter-input-{{ $product->id }}" class="flex items-center justify-center text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 rounded-full h-6 w-6 transition-all focus:outline-none">
                                        <svg class="w-3 h-3 text-gray-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-7 7V5"/></svg>
                                    </button>
                                </div>
                            </td>
                            <td class="p-4 font-semibold text-gray-900">Rp. {{ number_format($product->harga, 0, ',', '.') }}</td>
                            <td class="p-4 text-center">
                                <div class="flex items-center justify-center space-x-3">
                                    <a href="{{ route('products.edit', $product->id) }}" class="text-blue-600 hover:text-blue-800 font-medium transition-colors">Edit</a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline m-0 p-0" onsubmit="return confirm('Delete this product?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-medium transition-colors cursor-pointer focus:outline-none">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-sm text-gray-400 font-medium">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layout>