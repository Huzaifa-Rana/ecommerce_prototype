<nav class="bg-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-xl font-bold text-gray-800">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:flex sm:space-x-8 sm:ml-10">
                    <a href="{{ route('products.index') }}" class="inline-flex items-center px-1 pt-1 text-gray-500 hover:text-gray-700">
                        Products
                    </a>
                    @auth
                        @if(auth()->user()->hasRole('admin'))
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-1 pt-1 text-gray-500 hover:text-gray-700">
                                Dashboard
                            </a>
                            <a href="{{ route('admin.products.index') }}" class="inline-flex items-center px-1 pt-1 text-gray-500 hover:text-gray-700">
                                Manage Products
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="flex items-center">
                <!-- Cart -->
                <a href="{{ route('cart.index') }}" class="text-gray-500 hover:text-gray-700 px-3 py-2 relative">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    @if(session()->has('cart') && count(session('cart')) > 0)
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full">
                            {{ count(session('cart')) }}
                        </span>
                    @endif
                </a>

                <!-- Authentication Links -->
                @guest
                    <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-700 px-3 py-2">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="text-gray-500 hover:text-gray-700 px-3 py-2">
                        Register
                    </a>
                @else
                    <div class="ml-3 relative">
                        <div>
                            <span class="text-gray-500">{{ Auth::user()->name }}</span>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-500 hover:text-gray-700 px-3 py-2">
                                Logout
                            </button>
                        </form>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>
