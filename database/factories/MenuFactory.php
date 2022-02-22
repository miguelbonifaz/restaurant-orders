<?php

namespace Database\Factories;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class MenuFactory extends Factory
{
    protected $model = Menu::class;

    public function definition(): array
    {
        return [
            "name" => $this->faker->name,
            "description" => $this->faker->text,
            "price" => rand(10, 50) . '.' . collect([10, 15, 20, 25, 30, 35, 40, 45, 50])->random(),
            'quantity' => rand(5, 12),
        ];
    }
}
