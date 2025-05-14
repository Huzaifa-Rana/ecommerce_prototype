<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct()
    {
        // No middleware needed - cart is available to everyone
    }

    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function add(Product $product)
    {
        // Check if product is in stock
        if ($product->stock <= 0) {
            return back()->with('error', 'Product is out of stock');
        }

        $cart = session()->get('cart', []);

        // If product is already in cart, increase quantity if stock allows
        if (isset($cart[$product->id])) {
            if ($cart[$product->id]['quantity'] >= $product->stock) {
                return back()->with('error', 'Cannot add more of this product - stock limit reached');
            }
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
            ];
        }

        session()->put('cart', $cart);
        session()->put('last_cart_action', request()->url()); // Store last cart action URL

        return back()->with('success', 'Product added to cart!');
    }

    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);
        unset($cart[$product->id]);
        session()->put('cart', $cart);

        return back()->with('success', 'Product removed from cart!');
    }
}
