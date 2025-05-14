<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        // Get the cart from the session
        $cart = session()->get('cart', []);

        return view('cart.index', compact('cart'));
    }

    public function add(Product $product)
    {
        // Get the current cart from session
        $cart = session()->get('cart', []);

        // If product is already in the cart, increase quantity
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
            ];
        }

        // Save the cart back to the session
        session()->put('cart', $cart);

        return redirect()->route('cart.index');
    }

    public function remove(Product $product)
    {
        // Remove product from the cart
        $cart = session()->get('cart', []);
        unset($cart[$product->id]);

        session()->put('cart', $cart);

        return redirect()->route('cart.index');
    }
}
