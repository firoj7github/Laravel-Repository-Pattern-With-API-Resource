<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data =[
            [
               'country_name' => 'Bangladesh',
               'country_area'=>'kushtia'
            ],
            [
               'country_name' => 'Iran',
               'country_area'=>'Teheran'
            ]
            ];

            Country::insert($data);
    }
}
