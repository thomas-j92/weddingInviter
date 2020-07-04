<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaveTheDatesBulkSend extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('save_the_dates_bulk_send_elements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('invite_id');
            $table->unsignedBigInteger('container_id');
            $table->longText('status');
            $table->timestamps();

            $table->foreign('invite_id')->references('id')->on('invites');
            $table->foreign('container_id')->references('id')->on('save_the_dates_bulk_send_containers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('save_the_dates_bulk_send_elements');
    }
}
