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
    <div class="max-w-2xl mx-auto mt-8 px-4">
        <h1 class="text-xl font-semibold text-gray-800 mb-6">Add Customer</h1>

        <form action="{{ route('customers.store') }}" method="POST"
              class="bg-white shadow-sm border border-gray-200 rounded-lg p-6">
            @include('customers._form')

            <div class="flex justify-end gap-3 mt-6">
                <a href="{{ route('customers.index') }}"
                   class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800">Cancel</a>
                <button type="submit"
                        class="px-4 py-2 text-sm font-medium bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                    Save Customer
                </button>
            </div>
        </form>
    </div>
</x-layout>