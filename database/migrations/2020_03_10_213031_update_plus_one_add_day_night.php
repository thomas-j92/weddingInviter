<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePlusOneAddDayNight extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plus_ones', function (Blueprint $table) {
            if(!Schema::hasColumn('plus_ones', 'rsvp')){
                $table->boolean('rsvp')->default(0);
            }
            
            if(!Schema::hasColumn('plus_ones', 'attending_day')){
                $table->boolean('attending_day')->default(0);
            }
            if(!Schema::hasColumn('plus_ones', 'attending_night')){
                $table->boolean('attending_night')->default(0);
            }

            if(Schema::hasColumn('plus_ones', 'attending')){
                $table->dropColumn('attending');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plus_ones', function (Blueprint $table) {
            if(!Schema::hasColumn('plus_ones', 'attending')){
                $table->boolean('attending')->default(0);
            }

            if(Schema::hasColumn('plus_ones', 'rsvp')){
                $table->dropColumn('rsvp');
            }
            if(Schema::hasColumn('plus_ones', 'attending_day')){
                $table->dropColumn('attending_day');
            }
            if(Schema::hasColumn('plus_ones', 'attending_night')){
                $table->dropColumn('attending_night');
            }
        });
    }
}
