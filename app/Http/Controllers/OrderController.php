<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;

class OrderController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        request()->validate([
            'client_name' => 'required',
        ]);

        $order = Order::create([
            'table_number' => request('table_number'),
            'client_name' => request('client_name'),
        ]);

        collect(request('ordersId'))->each(function ($data) use ($order) {
            $order->foods()->attach($data['orderId'], ['quantity' => $data['quantity']]);
        });

        return redirect()
            ->route('home.index')
            ->with('message', 'Su pedido se realizó con éxito');
    }
}