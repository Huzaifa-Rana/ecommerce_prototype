@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Admin Dashboard</h2>
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5>Total Products</h5>
                    <p>{{ $totalProducts }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5>Total Orders</h5>
                    <p>{{ $totalOrders }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-dark">
                <div class="card-body">
                    <h5>Total Revenue</h5>
                    <p>${{ number_format($totalRevenue, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <h4>Customer Orders</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Customer</th>
                <th>Email</th>
                <th>Total Orders</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $customer)
                <tr>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->orders_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
