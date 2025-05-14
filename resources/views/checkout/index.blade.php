@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Checkout</h2>

    <h4>Your Cart</h4>
    <ul>
        @foreach($cart as $item)
            <li>{{ $item['name'] }} - ${{ $item['price'] }} x {{ $item['quantity'] }} = ${{ $item['price'] * $item['quantity'] }}</li>
        @endforeach
    </ul>

    <h4>Total: ${{ $total }}</h4>

    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-success">Pay with Stripe</button>
    </form>
</div>
@endsection
