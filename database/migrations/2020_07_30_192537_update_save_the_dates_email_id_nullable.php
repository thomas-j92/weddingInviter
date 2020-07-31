<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSaveTheDatesEmailIdNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('save_the_dates', function (Blueprint $table) {
            $table->unsignedBigInteger('email_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('save_the_dates', function (Blueprint $table) {
            $table->unsignedBigInteger('email_id')->nullable(false)->change();
        });
    }
}
