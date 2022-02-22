<?php

namespace Database\Factories;

use App\Models\Menu;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'table_number' => $this->faker->randomNumber(),
            'client_name' => $this->faker->name(),
            'status' => Order::STATUS_PENDING,
            'completed_at' => null,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Order $order) {
            $plates = Menu::factory(rand(2, 5))->create();

            $plates->each(function ($plate) use ($order) {
                $order->foods()->attach($plate->id, [
                    'quantity' => rand(1, 5),
                ]);
            });
        });
    }

    public function completed()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => Order::STATUS_COMPLETED,
                'completed_at' => today()
            ];
        });
    }
}
