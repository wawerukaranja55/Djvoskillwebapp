<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductattributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productattributes', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->string('productattr_size');
            $table->string('productattr_price');
            $table->string('productattr_stock');
            $table->string('productattr_sku');
            $table->boolean('productattr_status')->default('0');
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
        Schema::dropIfExists('productattributes');
    }
}
