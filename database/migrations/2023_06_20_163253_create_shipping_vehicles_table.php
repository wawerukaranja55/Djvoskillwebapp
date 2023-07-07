<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_vehicles', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');
            $table->string('vehicle_reg_no');
            $table->string('vehicle_driver');
            $table->text('vehicle_change_info')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipping_vehicles');
    }
}
