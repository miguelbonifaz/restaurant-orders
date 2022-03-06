<?php

use App\Events\UpdateOrdersEvent;
use App\Models\Menu;
use App\Models\MenuOrder;
use App\Models\Order;
use function Pest\Laravel\post;

function createOrder($data = []): \Illuminate\Testing\TestResponse
{
    $uri = route('orders.store');

    return post($uri, $data);
}

test('can create a order with several foods', function () {
    \Illuminate\Support\Facades\Event::fake();

    // Arrange
    $plateOne = Menu::factory()->create([
        'quantity' => $plateOneQuantity = 2,
    ]);
    $plateTwo = Menu::factory()->create([
        'quantity' => $plateTwoQuantity = 1,
    ]);

    // Act
    $response = createOrder([
        'ordersId' => [
            [
                'orderId' => $plateOne->id,
                'quantity' => 2,
            ],
            [
                'orderId' => $plateTwo->id,
                'quantity' => 1,
            ],
        ],
        'client_name' => $clientName = 'Client Name',
        'table_number' => $tableNumber = 1,
    ]);

    // Assert
    Event::assertDispatched(UpdateOrdersEvent::class);

    $response->assertRedirect(route('home.index'));
    $response->assertSessionHas('message', 'Su pedido se realizó con éxito');

    $this->assertCount(1, Order::all());
    $this->assertCount(2, MenuOrder::all());

    $this->assertEquals(0, $plateOne->fresh()->quantity);
    $this->assertEquals(0, $plateTwo->fresh()->quantity);

    $order = Order::first();
    $this->assertCount(2, $order->foods);

    $menuOrderOne = MenuOrder::first();
    $this->assertEquals($order->id, $menuOrderOne->order_id);
    $this->assertEquals(2, $menuOrderOne->quantity);

    $menuOrderTwo = MenuOrder::all()->last();
    $this->assertEquals($order->id, $menuOrderTwo->order_id);
    $this->assertEquals(1, $menuOrderTwo->quantity);

    $this->assertEquals($clientName, $order->client_name);
    $this->assertEquals($tableNumber, $order->table_number);
});

test('cannot create a order if a menu it is not available', function () {
    // Arrange
    $plateOne = Menu::factory()->create([
        'quantity' => 0,
    ]);

    // Act
    $response = createOrder([
        'ordersId' => [
            [
                'orderId' => $plateOne->id,
                'quantity' => 1,
            ]
        ],
        'client_name' => $clientName = 'Client Name',
        'table_number' => $tableNumber = 1,
    ]);

    // Assert
    $response->assertRedirect(route('home.index'));
    $response->assertSessionHas('message_warning', "El siguiente menú ya no se encuentra disponible: $plateOne->name");
    $response->assertSessionMissing('message');

    $this->assertCount(0, Order::all());
    $this->assertCount(0, MenuOrder::all());
});

test('fields are required', function () {
    // Arrange
    $plateOne = Menu::factory()->create();
    $plateTwo = Menu::factory()->create();

    // Act
    $response = createOrder([
        'ordersId' => [
            [
                'orderId' => $plateOne->id,
                'quantity' => 2,
            ],
            [
                'orderId' => $plateTwo->id,
                'quantity' => 1,
            ],
        ],
        'client_name' => null,
        'table_number' => null,
    ]);

    // Assert
    $response->assertSessionHasErrors([
        'client_name',
        'table_number',
    ]);
});