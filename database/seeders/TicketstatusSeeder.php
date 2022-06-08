<?php

namespace Database\Seeders;

use App\Models\Ticketstatus;
use Illuminate\Database\Seeder;

class TicketstatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ticketstatus::create(['ticket_type'=>'Purchase']);
    }
}
