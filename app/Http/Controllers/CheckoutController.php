<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $user = auth()->user();
        $items = CartItem::with('book')
            ->where('user_id', $user->id)
            ->get();

        if ($items->count() === 0) {
            return redirect()->back()->with('error', 'The cart was empty');
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $lineItems = [];
        foreach ($items as $item) {
            $lineItems[] = [
                'quantity' => $item->quantity,
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => intval($item->book->price * 100),
                    'product_data' => [
                        'name' => $item->book->title,
                        'images' => ['https://stripe.com/img/documentation/checkout/marketplace.png'],
                    ],
                ],
            ];
        }

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',

            'shipping_address_collection' => [
                'allowed_countries' => ['IE', 'GB', 'US', 'CA', 'PT']
            ],

            'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel') . '?session_id={CHECKOUT_SESSION_ID}',
        ]);

        $order = Order::create([
            'user_id' => auth()->id(),
            'stripe_session_id' => $session->id,
            'status' => 'pending',
            'total' => $session->amount_total / 100
        ]);

        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'book_id' => $item->book_id,
                'quantity' => $item->quantity,
                'price' => floatval($item->book->price),
                'subtotal' => floatval($item->book->price) * $item->quantity,
            ]);
        }

        return redirect($session->url);
    }

    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');

        if (!$sessionId) {
            abort(404);
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::retrieve($sessionId);
        $addressInfo = $session->customer_details->address;

        $order = Order::where('stripe_session_id', $session->id)->firstOrFail();

        $order->update([
            'status' => 'paid',
            'total' => $session->amount_total / 100,
            'address_line1' => $addressInfo->line1,
            'address_line2' => $addressInfo->line2,
            'city' => $addressInfo->city,
            'postal_code' => $addressInfo->postal_code,
            'country' => $addressInfo->country,
        ]);

        CartItem::where('user_id', $order->user_id)->delete();

        return view('checkout.success', compact('order'));
    }

    public function cancel(Request $request)
    {
        $sessionId = $request->query('session_id');

        $order = Order::where('stripe_session_id', $sessionId)->first();
        if ($order) {
            $order->update(['status' => 'canceled']);
        }

        return view('checkout.cancel');
    }

    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $signature = $request->header('Stripe-Signature');
        $secret = config('services.stripe.webhook_secret');
    }
}
