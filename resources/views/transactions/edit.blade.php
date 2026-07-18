<x-layout>
<div class="max-w-7xl mx-auto py-8 px-6">
    <div class="bg-white rounded-xl shadow border border-gray-200">
        <div class="border-b px-6 py-4">
            <h1 class="text-2xl font-bold text-gray-800">Edit Transaksi</h1>
        </div>
        <form action="{{ route('transactions.update', $transaction->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('transactions._edit_form')
        </form>
    </div>
</div>
</x-layout>