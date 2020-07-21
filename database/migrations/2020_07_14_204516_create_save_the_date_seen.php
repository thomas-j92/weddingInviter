<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaveTheDateSeen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('save_the_date_seen', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('save_the_date_id');
            $table->string('email');
            $table->timestamps();

            $table->foreign('save_the_date_id')->references('id')->on('save_the_dates');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('save_the_date_seen');
    }
}
