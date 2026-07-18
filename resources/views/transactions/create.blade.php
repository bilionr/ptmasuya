<x-layout>
<div class="max-w-7xl mx-auto py-8 px-6">
    <div class="bg-white rounded-xl shadow border border-gray-200">
        <div class="border-b px-6 py-4">
            <h1 class="text-2xl font-bold text-gray-800">Add Transaction</h1>
        </div>
        <form action="{{ route('transactions.store') }}" method="POST">
            @csrf
            @include('transactions._form')
        </form>
    </div>
</div>
</x-layout>