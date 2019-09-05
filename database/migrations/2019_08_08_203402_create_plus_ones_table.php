<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlusOnesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plus_ones', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('invite_id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->boolean('attending')->default(0);
            $table->boolean('vegetarian')->default(0);
            $table->boolean('vegan')->default(0);
            $table->longText('dietary_requirements')->nullable();
            $table->timestamps();

            $table->foreign('invite_id')->references('id')->on('invites');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plus_ones');
    }
}
