<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Database\Seeder;

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
            ['name' => 'Arroz con pollo y menestra'],
            ['name' => 'Arroz con cangrejo'],
            ['name' => 'Seco de pollo'],
            ['name' => 'Seco de chancho'],
            ['name' => 'Parrillada de Carne y Pollo'],
            ['name' =>  'Pescado con patacones y ensalada'],
            ['name' => 'Lomo de carne con porción de papas fritas']
        ]);
    }
}
