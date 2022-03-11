<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedInteger('table_number');
            $table->string('client_name');
            $table->string('status');
            $table->date('completed_at')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
    }
}