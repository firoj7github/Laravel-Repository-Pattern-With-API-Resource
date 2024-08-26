<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
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
                'name'=> 'omor forid',
                'email'=>'forid@gmail.com',
                'country_id'=>'1'
            ],
            [
                'name'=> 'alamin',
                'email'=>'alamin@gmail.com',
                'country_id'=>'2'
            ],
        ];

        Customer::insert($data);
    }
}
