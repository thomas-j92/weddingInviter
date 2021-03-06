<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSaveTheDateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('save_the_dates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('invite_id');
            $table->unsignedBigInteger('email_id');
            $table->longText('to');
            $table->longText('cc')->nullable();
            $table->timestamps();

            $table->foreign('invite_id')->references('id')->on('invites');
            $table->foreign('email_id')->references('id')->on('emails');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('save_the_dates');
    }
}
