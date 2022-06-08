<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableMerchadises extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('merchadises', function (Blueprint $table) {
            $table->enum('is_featured',['No','Yes'])->after('merchcat_id');
            $table->string('meta_name')->after('is_featured');
            $table->string('meta_description')->after('meta_name');
            $table->string('meta_keywords')->after('meta_description');
            $table->string('fabric')->after('meta_keywords');
            $table->string('occasion')->after('fabric');
            $table->string('merch_video')->after('merch_image');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
