@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Your Cart</h2>

    @if(session()->has('cart') && count(session('cart')) > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th><th>Price</th><th>Quantity</th><th>Total</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach(session('cart') as $productId => $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>${{ number_format($item['price'], 2) }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                        <td>
                            <form action="{{ route('cart.remove', $productId) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('checkout.index') }}" class="btn btn-primary">Proceed to Checkout</a>
    @else
        <p>Your cart is empty.</p>
    @endif
</div>
@endsection
