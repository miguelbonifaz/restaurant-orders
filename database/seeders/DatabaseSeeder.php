<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Event;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'email' => 'miguel@gmail.com'
        ]);

        Menu::factory()->createMany([
            ['name' => 'Arroz con pollo y menestra', 'quantity' => rand(1,3)],
            ['name' => 'Arroz con cangrejo', 'quantity' => rand(1,3)],
            ['name' => 'Seco de pollo', 'quantity' => rand(1,3)],
            ['name' => 'Seco de chancho', 'quantity' => rand(1,3)],
            ['name' => 'Parrillada de Carne y Pollo', 'quantity' => rand(1,3)],
            ['name' => 'Pescado con patacones y ensalada', 'quantity' => rand(1,3)],
            ['name' => 'Lomo de carne con porción de papas fritas', 'quantity' => rand(1,3)]
        ]);

        return null;

        for ($i = 0; $i < 4; $i++) {
            $order = Order::factory()->create();
            $order->foods()->detach();

            $menu = Menu::inRandomOrder()
                ->whereIn('id', $menus->pluck('id'))
                ->take(rand(2, 4))
                ->get()
                ->values();

            $menu->each(function (Menu $menu) use ($order) {
                $order->foods()->attach($menu->id, [
                    'quantity' => rand(1, 3)
                ]);
            });

            if ($i == 3) {
                $order->update([
                    'status' => 'completed'
                ]);
            }
        }
    }
}
