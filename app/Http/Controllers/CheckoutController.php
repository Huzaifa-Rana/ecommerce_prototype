<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:customer']);
    }

    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('products.index')
                ->with('error', 'Your cart is empty');
        }

        // Calculate total
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Create Stripe Payment Intent
        Stripe::setApiKey(config('services.stripe.secret'));

        $paymentIntent = PaymentIntent::create([
            'amount' => $total * 100, // Amount in cents
            'currency' => 'usd',
            'metadata' => [
                'user_id' => auth()->id()
            ]
        ]);

        return view('checkout.index', [
            'cart' => $cart,
            'total' => $total,
            'clientSecret' => $paymentIntent->client_secret,
        ]);
    }

    public function process(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('products.index')
                ->with('error', 'Your cart is empty');
        }

        try {
            DB::beginTransaction();

            // Create order
            $total = 0;
            foreach ($cart as $productId => $item) {
                $total += $item['price'] * $item['quantity'];
            }

            $order = Order::create([
                'user_id' => auth()->id(),
                'total_amount' => $total,
                'status' => 'completed',
            ]);

            // Create order items and update product stock
            foreach ($cart as $productId => $item) {
                $product = Product::findOrFail($productId);

                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Not enough stock for {$product->name}");
                }

                // Create order item
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                // Update stock
                $product->update([
                    'stock' => $product->stock - $item['quantity']
                ]);
            }

            // Clear cart
            session()->forget('cart');

            DB::commit();

            return redirect()->route('products.index')
                ->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error processing your order: ' . $e->getMessage());
        }
    }
}
