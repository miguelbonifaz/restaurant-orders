<?php

use App\Models\Order;
use Inertia\Testing\Assert;

test('can see order list', function () {
    // Arrange
    Order::factory(5)->create();

    $uri = route('dashboard');

    // Act
    $response = $this->actingAsRandomUser()->get($uri);

    // Assert
    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('Orders/Index')
        ->has('orders.data', 5)
    );
});

test('can see only today orders', function () {
    // Arrange
    $order = Order::factory()->create();

    Order::factory()->create([
        'created_at' => now()->subDay()
    ]);

    $uri = route('dashboard');

    // Act
    $response = $this->actingAsRandomUser()->get($uri);

    // Assert
    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('Orders/Index')
        ->has('orders.data', 1)
        ->where('orders.data.0.id', $order->id)
    );
});

test('can see orders with status pending', function () {
    // Arrange
    $order = Order::factory()->create();

    Order::factory()->completed()->create();

    $uri = route('dashboard');

    // Act
    $response = $this->actingAsRandomUser()->get($uri);

    // Assert
    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('Orders/Index')
        ->has('orders.data', 1)
        ->where('orders.data.0.id', $order->id)
    );
});

