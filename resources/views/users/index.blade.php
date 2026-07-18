<x-layout>
    <div class="max-w-screen-lg mx-auto mt-6 px-4">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Registered Users</h1>
            <span class="bg-purple-100 text-purple-800 text-xs font-semibold px-2.5 py-1 rounded-full">
                Total: {{ $users->count() }} Users
            </span>
        </div>
        <div class="overflow-hidden bg-white shadow-md rounded-lg border border-slate-200">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="p-4 text-sm font-semibold tracking-wide text-slate-700 w-16 text-center">ID</th>
                        <th class="p-4 text-sm font-semibold tracking-wide text-slate-700">Name</th>
                        <th class="p-4 text-sm font-semibold tracking-wide text-slate-700">Email</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($users as $user)
                        <tr class="hover:bg-slate-50 transition-colors duration-150 odd:bg-white even:bg-slate-50/50">
                            <td class="p-4 text-sm font-medium text-slate-500 text-center font-mono">
                                {{ $user->id }}
                            </td>
                            <td class="p-4 text-sm font-semibold text-slate-800">
                                {{ $user->name }}
                            </td>
                            <td class="p-4 text-sm text-slate-600">
                                {{ $user->email }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layout>