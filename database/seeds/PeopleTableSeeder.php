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
                'status'        => 'active',
	            'email' 		=> $faker->email,
	            'created_at' 	=> date('Y-m-d H:i:s')
	        ]);
    	}
    }
}
