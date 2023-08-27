<?php

namespace Database\Seeders;

use App\Models\Event_category;
use Illuminate\Database\Seeder;

class Event_category_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $eventcategories=[
            ['id'=>1,'eventcategory_title'=>'Ruracio'],
            ['id'=>2,'eventcategory_title'=>'Wedding'],
            ['id'=>3,'eventcategory_title'=>'Birthday Party'],
            ['id'=>4,'eventcategory_title'=>'Graduation Party'],
            ['id'=>5,'eventcategory_title'=>'Corporate Event'],
            ['id'=>6,'eventcategory_title'=>'Concert'],
            ['id'=>7,'eventcategory_title'=>'Club gig'],
            ['id'=>8,'eventcategory_title'=>'Brand Activation'],
        ];

        Event_category::insert($eventcategories);
    }
}
