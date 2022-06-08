<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchadisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchadises', function (Blueprint $table) {
            $table->id();
            $table->string('merch_name');
            $table->string('merch_code');
            $table->integer('merch_price');
            $table->string('merch_image');
            $table->boolean('merch_isactive')->default('0');
            $table->text('merch_details');
            $table->integer('merchcat_id');
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
        Schema::dropIfExists('merchadises');
    }
}
