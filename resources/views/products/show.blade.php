<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $product->name }} - {{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        @include('layouts.navigation')

        <main class="container mx-auto py-8 px-4">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-6">
                    <h1 class="text-3xl font-bold mb-4">{{ $product->name }}</h1>
                    <div class="text-gray-600 mb-6">{{ $product->description }}</div>
                    
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-2xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                            <span class="text-gray-600 ml-2">Stock: {{ $product->stock }}</span>
                        </div>
                        
                        @if($product->stock > 0)
                            <form action="{{ route('cart.add', $product) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg">
                                    Add to Cart
                                </button>
                            </form>
                        @else
                            <span class="text-red-500 font-semibold text-lg">Out of Stock</span>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
