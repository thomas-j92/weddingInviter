<?php

use Illuminate\Database\Seeder;

class PeopleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$faker = Faker\Factory::create();

    	$num_records = 10;

    	for($i = 0; $i < 10; $i++) {
	        DB::table('people')->insert([
	            'first_name' 	=> $faker->firstName,
	            'last_name' 	=> $faker->lastName,
	            'email' 		=> $faker->email,
	            'attending' 	=> $faker->boolean,
	            'rsvp' 			=> $faker->boolean,
	            'created_at' 	=> date('Y-m-d H:i:s')
	        ]);
    	}
    }
}
