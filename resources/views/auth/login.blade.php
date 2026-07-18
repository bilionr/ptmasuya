<!-- resources/views/login.blade.php -->

<x-layout> 
  <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
      <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500" alt="Your Company" class="mx-auto h-10 w-auto" />
      <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-white">Sign in to your account</h2>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <form action="{{ route('login') }}" method="POST" class="space-y-6">
        <div>
          <label for="email" class="block text-sm/6 font-semibold text-black">Email address [admin@gmail.com]</label>
          <div class="mt-2">
              <input id="email" type="email" name="email" class="block w-full rounded-md bg-white border-2 border-purple-300 px-3 py-1.5 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none focus:border-purple-600 focus:ring-2 focus:ring-purple-600/20 sm:text-sm/6" />
          </div>
      </div>

        <div>
          <div class="flex items-center justify-between">
            <label for="password" class="block text-sm/6 font-medium text-black">Password [admin]</label>
            <div class="text-sm">
              <a href="#" class="font-semibold text-indigo-400 hover:text-indigo-300">Forgot password?</a>
            </div>
          </div>
          <div class="mt-2">
            <input id="password" type="password" name="password" class="block w-full rounded-md bg-white border-2 border-purple-300 px-3 py-1.5 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none focus:border-purple-600 focus:ring-2 focus:ring-purple-600/20 sm:text-sm/6" />
          </div>
        </div>

        <div>
          <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-500 px-3 py-1.5 text-sm/6 font-semibold text-white hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Sign in</button>
        </div>
      </form>

      <p class="mt-10 text-center text-sm/6 text-gray-400">
        <a href="{{ route('register') }}" class="font-semibold text-indigo-400 hover:text-indigo-300">Register</a>
      </p>
    </div>
  </div>
</x-layout>