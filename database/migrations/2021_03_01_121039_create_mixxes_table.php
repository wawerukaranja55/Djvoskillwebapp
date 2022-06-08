<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMixxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mixxes', function (Blueprint $table) {
            $table->id();
            $table->string('mix_name');
            $table->string('mix_audio');
            $table->string('mix_image');
            $table->integer('mix_size');
            $table->integer('mix_length')->nullable();
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
        Schema::dropIfExists('mixxes');
    }
}
