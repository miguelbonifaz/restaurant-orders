<?php

use App\Models\Order;

test('can finalize a order', function () {
    // Arrange
    $order = Order::factory()->create();

    $uri = route('orders.finalize', $order);

    // Act
    $response = $this->actingAsRandomUser()->post($uri);

    // Assert
    $response->assertRedirect(route('dashboard'));

    $response->assertSessionHas('message', "La Order #$order->id ha sido finalizada");

    $this->assertTrue($order->fresh()->isFinalized());
});