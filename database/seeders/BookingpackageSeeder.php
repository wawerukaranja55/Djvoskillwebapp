<?php

namespace Database\Seeders;

use App\Models\Bookingpackage;
use Illuminate\Database\Seeder;

class BookingpackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {	
        Bookingpackage::create(['package_name'=>'Dj and Full Sound System',
                                'package_description'=>'Dj and Full Sound System.Dj and Full Sound System',
                                'package_price'=>'sh 80,000']);
    }
}
