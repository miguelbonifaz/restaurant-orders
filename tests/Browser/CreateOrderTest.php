<?php

namespace Tests\Browser;

use App\Models\Menu;
use App\Models\Order;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CreateOrderTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test
     * @throws \Throwable
     */
    public function can_create_a_order()
    {
        $menuOne = Menu::factory()->create(['quantity' => 1]);
        $menuTwo = Menu::factory()->create(['quantity' => 2]);

        $this->assertCount(0, Order::all());

        $this->browse(function (Browser $browserOne, Browser $browserTwo) use ($menuTwo, $menuOne) {
            $browserOne->visitRoute('home.index')
                ->click("@addOrder($menuOne->id)")
                ->click("@addOrder($menuTwo->id)")
                ->click('@verPedido')
                ->type('client_name', 'Miguel Bonifaz')
                ->select('table_number', 3);

            $browserTwo->visitRoute('home.index')
                ->click("@addOrder($menuOne->id)")
                ->click("@addOrder($menuTwo->id)")
                ->click('@verPedido')
                ->type('client_name', 'Joss Mora')
                ->select('table_number', 3);

            $browserOne
                ->click('@confirmarPedido')
                ->pause(2000)
                ->assertSee('Su pedido se realizó con éxito');

            $browserTwo
                ->click('@confirmarPedido')
                ->pause(2500)
                ->assertSee("El siguiente menú ya no se encuentra disponible o no hay muchas unidades disponibles: $menuOne->name")
                ->assertSeeIn("@order-list-$menuTwo->id", $menuTwo->name)
                ->assertDontSeeIn("@order-list-$menuOne->id", $menuOne->name)
            ;

            $this->assertEquals(0, $menuOne->fresh()->quantity);
            $this->assertEquals(1, $menuTwo->fresh()->quantity);

            $this->assertCount(1, Order::all());
            $this->assertCount(2, Order::first()->foods);
            $this->assertEquals(collect([$menuOne->id, $menuTwo->id]), Order::first()->foods->pluck('id'));
        });
    }
}
