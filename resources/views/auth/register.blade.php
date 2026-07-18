<x-layout>
<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500" alt="Your Company" class="mx-auto h-10 w-auto" />
        <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-black">Create an account</h2>
    </div>
    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
        @if ($errors->any())
            <div class="mb-6 rounded-md border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf
            <div>
                <label for="name" class="block text-sm/6 font-semibold text-black">Name</label>
                <div class="mt-2">
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required class="block w-full rounded-md bg-white border-2 border-purple-300 px-3 py-1.5 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none focus:border-purple-600 focus:ring-2 focus:ring-purple-600/20 sm:text-sm/6" />
                </div>
            </div>
            <div>
                <label for="email" class="block text-sm/6 font-semibold text-black">Email address</label>
                <div class="mt-2">
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required class="block w-full rounded-md bg-white border-2 border-purple-300 px-3 py-1.5 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none focus:border-purple-600 focus:ring-2 focus:ring-purple-600/20 sm:text-sm/6" />
                </div>
            </div>
            <div>
                <label for="password" class="block text-sm/6 font-semibold text-black">Password</label>
                <div class="mt-2">
                    <input id="password" type="password" name="password" required class="block w-full rounded-md bg-white border-2 border-purple-300 px-3 py-1.5 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none focus:border-purple-600 focus:ring-2 focus:ring-purple-600/20 sm:text-sm/6" />
                </div>
            </div>
            <div>
                <label for="password_confirmation" class="block text-sm/6 font-semibold text-black">Confirm Password</label>
                <div class="mt-2">
                    <input id="password_confirmation" type="password" name="password_confirmation" required class="block w-full rounded-md bg-white border-2 border-purple-300 px-3 py-1.5 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none focus:border-purple-600 focus:ring-2 focus:ring-purple-600/20 sm:text-sm/6" />
                </div>
            </div>
            <div>
                <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-500 px-3 py-1.5 text-sm/6 font-semibold text-white hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Register Account</button>
            </div>
        </form>
        <p class="mt-10 text-center text-sm/6 text-gray-500">
            Already have an account? <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-500 underline decoration-2">Login here</a>
        </p>
    </div>
</div>
</x-layout>