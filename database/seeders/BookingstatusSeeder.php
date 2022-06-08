<?php

namespace Database\Seeders;

use App\Models\Bookingstatus;
use Illuminate\Database\Seeder;

class BookingstatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bookingstatus::create(['bookingstatus'=>'Approved']);
        Bookingstatus::create(['bookingstatus'=>'Cancelled']);
        Bookingstatus::create(['bookingstatus'=>'DepositPaid']);
        Bookingstatus::create(['bookingstatus'=>'Published']);
    }
}
