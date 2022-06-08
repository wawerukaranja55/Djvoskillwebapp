<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogpostBlogtagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogpost_blogtag', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('blogtag_id');
            $table->foreign('blogtag_id')->references('id')->on('blogtags')->onDelete('cascade');
            
            $table->unsignedBigInteger('blogpost_id');
            $table->foreign('blogpost_id')->references('id')->on('blogposts')->onDelete('cascade');
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
        Schema::dropIfExists('blogpost_blogtag');
    }
}
