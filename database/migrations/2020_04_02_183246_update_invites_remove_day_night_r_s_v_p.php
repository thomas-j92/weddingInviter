<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateInvitesRemoveDayNightRSVP extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invites', function (Blueprint $table) {
            if(Schema::hasColumn('invites', 'day')){
                $table->dropColumn('day');
            }
            
            if(Schema::hasColumn('invites', 'night')){
                $table->dropColumn('night');
            }

            if(Schema::hasColumn('invites', 'rsvp_on')){
                $table->dropColumn('rsvp_on');
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
        Schema::table('invites', function (Blueprint $table) {
            if(!Schema::hasColumn('invites', 'day')){
                $table->boolean('day')->default(0);
            }
            
            if(!Schema::hasColumn('invites', 'night')){
                $table->boolean('night')->default(0);
            }

            if(!Schema::hasColumn('invites', 'rsvp_on')){
                $table->date('rsvp_on');
            }
        });
    }
}
