<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');

        $customers = User::where('role', 'customer')->withCount('orders')->get();

        return view('admin.dashboard', compact('totalProducts', 'totalOrders', 'totalRevenue', 'customers'));
    }
}
