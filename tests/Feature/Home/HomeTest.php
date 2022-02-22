<?php

use App\Models\Menu;
use Inertia\Testing\Assert;
use function Pest\Laravel\get;

function plateList($data = []): \Illuminate\Testing\TestResponse
{
    $uri = route("home.index", $data);

    return get($uri);
}

test("can see plate list", function () {
    // Arrange
    $plate = Menu::factory()->create(["name" => "Pizza"]);
    $plates = Menu::factory(10)->create();

    // Act
    $response = plateList();

    // Assert
    $response->assertInertia(
        fn(Assert $page) => $page->component("Home/Index")->has(
            "plates.data",
            11,
            fn(Assert $page) => $page
                ->where("id", $plate->id)
                ->where("name", $plate->name)
                ->where("description", $plate->description)
                ->where("price", $plate->price)
                ->where("quantity", $plate->quantity)
        )
    );
});

test(" can't see any plate if there is no availability", function () {
    // Arrange
    $plate = Menu::factory()->create(["name" => "Pizza"]);
    Menu::factory()->create(['quantity' => 0]);

    // Act
    $response = plateList();

    // Assert
    $response->assertInertia(
        fn(Assert $page) => $page->component("Home/Index")->has(
            "plates.data",
            1,
            fn(Assert $page) => $page
                ->where("id", $plate->id)
                ->where("name", $plate->name)
                ->where("description", $plate->description)
                ->where("price", $plate->price)
                ->where("quantity", $plate->quantity)
        )
    );
});

test("can filter by name", function () {
    // Arrange
    $plates = Menu::factory(10)->create();

    $plate = Menu::factory()->create();

    // Act
    $response = plateList([
        "search" => $plate->name,
    ]);

    // Assert
    $response->assertInertia(
        fn(Assert $page) => $page
            ->component("Home/Index")
            ->has("plates.data", 1)
            ->where("plates.data.0.id", $plate->id)
    );
});
