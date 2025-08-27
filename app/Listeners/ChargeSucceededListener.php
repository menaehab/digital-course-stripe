<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Laravel\Cashier\Events\WebhookReceived;
use App\Models\Cart;
use App\Models\Order;

class ChargeSucceededListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(WebhookReceived $event): void
    {
        if ($event->payload['type'] === 'charge.succeeded') {
            \Log::info($event->payload);
            $metadata = $event->payload['data']['object']['metadata'];

            $cart = Cart::where('user_id', $metadata['user_id'])->first();

            $order = Order::create([
                'user_id' => $metadata['user_id'],
            ]);

            $order->courses()->attach($cart->courses->pluck('id')->toArray());

            $cart->delete();
        }
    }
}
