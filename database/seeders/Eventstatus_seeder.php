<?php

namespace Database\Seeders;

use App\Models\Eventstatus;
use Illuminate\Database\Seeder;

class Eventstatus_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $eventstatus=[
            ['id'=>1,'event_status_title'=>'Upcoming'],
            ['id'=>2,'event_status_title'=>'Happening Today'],
            ['id'=>3,'event_status_title'=>'Postponed'],
            ['id'=>4,'event_status_title'=>'Cancelled'],
            ['id'=>5,'event_status_title'=>'Past Event']
        ];

        Eventstatus::insert($eventstatus);
    }
}
