<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateInviteGuestsAddDayNight extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invite_guests', function (Blueprint $table) {
            if(!Schema::hasColumn('invite_guests', 'rsvp')){
                $table->boolean('rsvp')->default(0);
            }
            
            if(!Schema::hasColumn('invite_guests', 'attending_day')){
                $table->boolean('attending_day')->default(0);
            }
            if(!Schema::hasColumn('invite_guests', 'attending_night')){
                $table->boolean('attending_night')->default(0);
            }

            if(Schema::hasColumn('invite_guests', 'attending')){
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
        Schema::table('invite_guests', function (Blueprint $table) {
            if(!Schema::hasColumn('invite_guests', 'attending')){
                $table->boolean('attending')->default(0);
            }

            if(Schema::hasColumn('invite_guests', 'rsvp')){
                $table->dropColumn('rsvp');
            }
            if(Schema::hasColumn('invite_guests', 'attending_day')){
                $table->dropColumn('attending_day');
            }
            if(Schema::hasColumn('invite_guests', 'attending_night')){
                $table->dropColumn('attending_night');
            }
        });
    }
}
