<?php

namespace Database\Seeders;

use App\Models\Events;
use App\Models\Ticketstatus;
use Illuminate\Database\Seeder;

class EventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $purchaseticketstatus=Ticketstatus::where(['ticket_type'=>'Puchase Ticket'])->first();

        $purchaseticket=Events::create([
            'eve_name'=>'The Rap Festival',
            'eve_details'=>'The Rap Festival will take place at whispers park in nyeri town',
            'is_ticket'=>1,
            'eve_location'=>'Whispers Park,Nyeri Town',
            'eve_time'=>'10.00 am',
            'eve_date'=>'13/9/2021',
            'eve_image'=>'eventimages/20210729124959.jpg',
        ]);

        $purchaseticket->ticketstatus()->attach($purchaseticketstatus);
    }

}
