<?php

use App\Models\Menu;
use function Pest\Laravel\post;

function createOrder($data = []): \Illuminate\Testing\TestResponse
{
    $uri = route('order.store');

    return post($uri, $data);
}

test('can create a order with severals foods', function () {
    // Arrange
    $plateOne = Menu::factory()->create();
    $plateTwo = Menu::factory()->create();

    // Act
    $response = createOrder([

    ]);

    // Assert
});