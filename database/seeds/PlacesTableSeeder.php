<?php

use Illuminate\Database\Seeder;

class PlacesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $places = include_once 'areas.php';

        foreach ($places as $key => $value) {
            DB::table('places')->insert([
                'address' => $key,
                'lat' => $value['lat'],
                'lng' => $value['long'],
            ]);
        }
    }
}
