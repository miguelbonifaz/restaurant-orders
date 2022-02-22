<?php

namespace App\Http\Controllers;

use App\Http\Resources\MenuResource;
use App\Models\Menu;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function __invoke(): \Inertia\Response
    {
        $plates = Menu::query()
            ->search(request('search'))
            ->withAvailableOrders()
            ->with('media')
            ->latest()
            ->get(['id', 'name', 'description', 'price', 'quantity']);

        $filterSearch = request('search');

        return Inertia::render('Home/Index', [
            'plates' => MenuResource::collection($plates),
            'filterSearch' => $filterSearch,
        ]);
    }
}