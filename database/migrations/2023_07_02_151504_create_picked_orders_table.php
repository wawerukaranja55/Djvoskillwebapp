<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePickedOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('picked_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');
            $table->string('recipient_id_number');
            $table->string('recipient_phone');
            $table->string('recipient_firstname');
            $table->string('recipient_lastname');
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
        Schema::dropIfExists('picked_orders');
    }
}
