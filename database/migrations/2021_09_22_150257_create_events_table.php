<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('event_name');
            $table->string('event_date');
            $table->string('event_time');
            $table->string('event_venue');
            $table->integer('eventcat_id');
            $table->string('location_latitude');
            $table->string('location_longitude');
            $table->string('is_ticket')->default('no');
            $table->boolean('is_active')->default('1');
            $table->string('ticket_link')->nullable(); 
            $table->string('event_location');
            $table->string('event_flyer');
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
        Schema::dropIfExists('events');
    }
}
