<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInviteGuestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invite_guests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('invite_id');
            $table->integer('person_id');
            $table->boolean('rsvp');
            $table->boolean('attending');
            $table->dateTime('rsvp_date');
            $table->timestamps();

            // Add foreign keys
            $table->foreign('invite_id')->references('id')->on('invites');
            $table->foreign('person_id')->references('id')->on('people');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invite_guests');
    }
}
