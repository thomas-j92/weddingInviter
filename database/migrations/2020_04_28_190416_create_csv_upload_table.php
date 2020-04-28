<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCsvUploadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('csv_upload_containers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
        });

        Schema::create('csv_uploads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('container_id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->boolean('day_guest')->nullable();
            $table->boolean('night_guest')->nullable();
            $table->boolean('rsvp_day')->nullable();
            $table->boolean('rsvp_night')->nullable();
            $table->boolean('wedding_venue')->nullable();

            $table->foreign('container_id')->references('id')->on('csv_upload_containers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('csv_upload_containers');
        Schema::dropIfExists('csv_upload');
    }
}
