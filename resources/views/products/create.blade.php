<x-layout>
    <div class="max-w-2xl mx-auto mt-8 px-4">
        <h1 class="text-xl font-semibold text-gray-800 mb-6">Add Produk</h1>

        <form action="{{ route('products.store') }}" method="POST"
              class="bg-white shadow-sm border border-gray-200 rounded-lg p-6">
            @include('products._form')

            <div class="flex justify-end gap-3 mt-6">
                <a href="{{ route('products.index') }}"
                   class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800">Cancel</a>
                <button type="submit"
                        class="px-4 py-2 text-sm font-medium bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                    Save Produk
                </button>
            </div>
        </form>
    </div>
</x-layout>