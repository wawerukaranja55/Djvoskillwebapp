<?php

namespace Database\Seeders;

use App\Models\Bookingcategory;
use Illuminate\Database\Seeder;

class BookingcategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bookingcategories=[
            ['id'=>1,'booking_category'=>'Ruracio'],
            ['id'=>2,'booking_category'=>'Wedding'],
            ['id'=>3,'booking_category'=>'Corporate Event'],
            ['id'=>4,'booking_category'=>'Tv Guest Dj'],
            ['id'=>5,'booking_category'=>'Radio Guest Dj'],
            ['id'=>6,'booking_category'=>'Club Guest Dj'],
            ['id'=>7,'booking_category'=>'Concert'],
            ['id'=>8,'booking_category'=>'Private Party'],
        ];

        Bookingcategory::insert($bookingcategories);
    }
}
