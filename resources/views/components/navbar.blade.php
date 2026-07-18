<nav class="block w-full max-w-screen-lg px-4 py-2 mx-auto bg-white shadow-md rounded-md lg:px-8 lg:py-3 mt-10">
  <div class="container flex flex-wrap items-center justify-between mx-auto text-slate-800">
    
    {{-- Brand Logo --}}
    <a href="{{ route('products.index') }}"
      class="mr-4 block cursor-pointer py-1.5 text-base text-slate-800 font-semibold transition-colors hover:text-purple-600">
      PT MASUYA
    </a>
    
    {{-- Desktop Menu Links --}}
    <div class="hidden lg:block">
      <ul class="flex flex-col gap-2 mt-2 mb-4 lg:mb-0 lg:mt-0 lg:flex-row lg:items-center lg:gap-6">
        @guest
            <li>
                <a href="{{ route('login') }}"
                class="text-purple-600 font-medium">
                    Login
                </a>
            </li>

            <li>
                <a href="{{ route('register') }}"
                class="text-purple-600 font-medium">
                    Register
                </a>
            </li>
        @endguest
        @auth
    
          {{-- Users --}}
          <li class="flex items-center p-1 text-sm gap-x-2 text-slate-600 font-medium transition-colors hover:text-purple-600">
              <a href="{{ route('users.index') }}" class="flex items-center">
                  Users
              </a>
          </li>

          {{-- Customer --}}
          <li class="flex items-center p-1 text-sm gap-x-2 text-slate-600 font-medium transition-colors hover:text-purple-600">
              <a href="{{ route('customers.index') }}" class="flex items-center">
                  Customer
              </a>
          </li>

          {{-- Product --}}
          <li class="flex items-center p-1 text-sm gap-x-2 text-slate-600 font-medium transition-colors hover:text-purple-600">
              <a href="{{ route('products.index') }}" class="flex items-center">
                  Product
              </a>
          </li>

          {{-- Transaction --}}
          <li class="flex items-center p-1 text-sm gap-x-2 text-slate-600 font-medium transition-colors hover:text-purple-600">
              <a href="{{ route('transactions.index') }}" class="flex items-center">
                  Transaction
              </a>
          </li>

                {{-- Logged-in user --}}
                <li class="flex items-center p-1 text-sm font-semibold text-slate-700 border-l border-slate-200 pl-4">
                    {{ auth()->user()->name }}
                </li>

                {{-- Logout --}}
                <li class="flex items-center p-1 text-sm gap-x-2 text-slate-600 font-medium transition-colors hover:text-purple-600">
                    <form action="{{ route('logout') }}" method="POST" class="m-0 p-0 inline-flex items-center">
                        @csrf
                        <button type="submit" class="focus:outline-none bg-transparent border-none cursor-pointer">
                            Logout
                        </button>
                    </form>
                </li>
            @else
        @endauth
      </ul>
    </div> {{-- This closes the hidden lg:block wrapper right here --}}

    {{-- Mobile Menu Button --}}
    <button
      class="relative ml-auto h-6 max-h-[40px] w-6 max-w-[40px] select-none rounded-lg text-center align-middle text-xs font-medium uppercase text-inherit transition-all hover:bg-transparent focus:bg-transparent active:bg-transparent disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none lg:hidden"
      type="button">
      <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
      </span>
    </button>
    
  </div>
</nav>