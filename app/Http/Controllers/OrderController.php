<?php

namespace App\Http\Controllers;

use App\Events\UpdateOrdersEvent;
use App\Http\Resources\OrderResource;
use App\Models\MenuOrder;
use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index(): \Inertia\Response
    {
        $orders = Order::query()
            ->with(['foods'])
            ->whereDate('created_at', today())
            ->withStatusPending()
            ->orderByDesc('id')
            ->get();

        $todayOrders = Order::query()
            ->whereDate('created_at', today())
            ->count();

        $pendingOrders = Order::query()
            ->whereDate('created_at', today())
            ->withStatusPending()
            ->count();

        $completedOrders = Order::query()
            ->whereDate('created_at', today())
            ->withStatusCompleted()
            ->count();

        return Inertia::render('Orders/Index', [
            'orders' => OrderResource::collection($orders),
            'todayOrders' => $todayOrders,
            'pendingOrders' => $pendingOrders,
            'completedOrders' => $completedOrders,
            'userId' => auth()->user()->id,
        ]);
    }

    public function store(): RedirectResponse
    {
        request()->validate([
            'table_number' => 'required',
            'client_name' => 'required',
        ]);

        $order = Order::create([
            'table_number' => request('table_number'),
            'client_name' => request('client_name'),
            'status' => Order::STATUS_PENDING,
        ]);

        collect(request('ordersId'))
            ->each(function ($data) use ($order) {
                $order->foods()->attach($data['orderId'], ['quantity' => $data['quantity']]);
            });

        UpdateOrdersEvent::dispatch();

        return redirect()
            ->route('home.index')
            ->with('message', 'Su pedido se realizó con éxito');
    }
}