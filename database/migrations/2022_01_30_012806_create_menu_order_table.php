<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuOrderTable extends Migration
{
    public function up()
    {
        Schema::create('menu_order', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->foreignId('order_id')->constrained();
            $table->foreignId('menu_id')->constrained('menu');
            $table->unsignedInteger('quantity');

            $table->timestamps();
        });
    }

    public function down()
    {
    }
}