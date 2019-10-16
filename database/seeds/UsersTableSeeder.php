<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	$userArr = array(
    		0 => array (
    			'name'	=> 'Thomas Jinks',
    			'email'	=> 'tommy_jinks@hotmail.co.uk',
           		'password' => bcrypt('secret'),

    		)
    	);
        
        foreach($userArr as $user) {
    		DB::table('users')->insert($user);
    	}
    	
    }
}
