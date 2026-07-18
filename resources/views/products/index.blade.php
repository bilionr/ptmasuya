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
        <h1 class="text-xl font-semibold text-gray-800">Products</h1>
        <a href="{{ route('products.create') }}"
            class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg shadow-sm transition">
            + Add Product
        </a>
    </div>
    <div class="relative overflow-x-auto bg-white shadow-sm rounded-lg border border-gray-200">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
            <thead class="text-xs font-semibold uppercase text-gray-700 bg-gray-50 border-b border-gray-200">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        <span class="sr-only">Image</span>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Product
                    </th>
                    <th scope="col" class="px-6 py-3 text-center">
                        Qty
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Price
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($products as $product)
                    <tr class="bg-white hover:bg-gray-50 transition-colors">
                        <!-- Product Image -->
                        <td class="p-4 w-32">
                            <!-- Assumed 'image' property exists, fallback to a placeholder if empty -->
                            <img src="{{ $product->image ?? '/docs/images/products/apple-watch.png' }}" 
                                class="w-16 md:w-24 max-w-full h-auto object-contain" 
                                alt="{{ $product->nama_produk}}">
                        </td>
                        
                        <!-- Product Name -->
                        <td class="px-6 py-4 font-semibold text-gray-900">
                            {{ $product->nama_produk }}
                        </td>
                        
                        <!-- Quantity Counter Controls -->
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center space-x-2">
                                <button type="button" 
                                        id="decrement-button-{{ $product->id }}" 
                                        data-input-counter-decrement="counter-input-{{ $product->id }}" 
                                        class="flex items-center justify-center text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 rounded-full text-sm font-medium h-6 w-6 transition-all focus:outline-none">
                                    <svg class="w-3 h-3 text-gray-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14"/>
                                    </svg>
                                </button>
                                
                                <!-- Notice the name="products[{{ $product->id }}][qty]" format to easily capture array inputs in your Controller request -->
                                <input type="text" 
                                    id="counter-input-{{ $product->id }}" 
                                    name="products[{{ $product->id }}][stok]"
                                    data-input-counter 
                                    class="w-10 text-center text-sm font-semibold text-gray-900 bg-transparent border-0 p-0 focus:ring-0 focus:outline-none" 
                                    value="{{ $product->stok ?? 1 }}" 
                                    required />
                                
                                <button type="button" 
                                        id="increment-button-{{ $product->id }}" 
                                        data-input-counter-increment="counter-input-{{ $product->id }}" 
                                        class="flex items-center justify-center text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 rounded-full text-sm font-medium h-6 w-6 transition-all focus:outline-none">
                                    <svg class="w-3 h-3 text-gray-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-7 7V5"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                        
                        <!-- Product Price -->
                        <td class="px-6 py-4 font-semibold text-gray-900">
                            ${{ number_format($product->harga, 0, ',', '.') }}
                        </td>
                        
                        <td>
                            <a href="{{ route('products.edit', $product->id) }}"
                                class="font-medium text-blue-600 hover:underline mr-3">Edit</a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this product?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="font-medium text-red-600 hover:underline cursor-pointer">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>



</x-layout>