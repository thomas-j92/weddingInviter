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
            $table->unsignedBigInteger('invite_id');
            $table->unsignedBigInteger('person_id');
            $table->string('type');
            $table->boolean('rsvp')->default(0);
            $table->boolean('attending')->default(0);
            $table->string('code')->nullable();
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
