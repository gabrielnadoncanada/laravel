<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        // We insert some dummy data
        $locations = array('Quebec', 'Montreal', 'Toronto','Vancouver', 'New-York', 'Ottawa', 'Calgary', 'Sherbrooke', 'Lachute', 'Laval');


        for ($i=0; $i < 10; $i++) 
        { 
        DB::table('locations')->insert([
            'name' => $locations[$i],
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        }
    }

}
