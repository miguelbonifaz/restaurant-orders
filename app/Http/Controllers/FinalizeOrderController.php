<?php

namespace App\Http\Controllers;

use App\Models\Order;

class FinalizeOrderController extends Controller
{
    public function __invoke()
    {
        /** @var Order $order */
        $order = request('order');

        $order->finalize();

        return redirect()
            ->route('dashboard')
            ->with('message', "La Order #{$order->id} ha sido finalizada");
    }
}