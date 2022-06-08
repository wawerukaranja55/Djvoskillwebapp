<?php

namespace Database\Seeders;

use App\Models\Bookings;
use App\Models\Bookingstatus;
use App\Models\Bookingpackage;
use Illuminate\Database\Seeder;

class BookingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $Approvedstatus=Bookingstatus::where('bookingstatus','Approved')->first();
        $Cancelledstatus=Bookingstatus::where('bookingstatus','Cancelled')->first();
        $DepositPaidstatus=Bookingstatus::where('bookingstatus','DepositPaid')->first();
        $Publishedstatus=Bookingstatus::where('bookingstatus','Published')->first();

        $Approved=Bookings::create([
            'full_name'=>'Weru Promoter',
            'location'=>'Nairobi',
            'phone'=>'0702521351',
            'is_booking'=>1,
            'email'=>'Werupromoter@admin.com',
            'date'=>'07/02/2021',
            'event_id'=>'2',
            'event_details'=>'we would like to book you for a wedding'

        ]);

        $DepositPaid=Bookings::create([
            'full_name'=>'Best Promoters',
            'location'=>'Nairobi',
            'phone'=>'0792492584',
            'is_booking'=>2,
            'email'=>'Werupromoter@admin.com',
            'date'=>'07/02/2021',
            'event_id'=>'5',
            'event_details'=>'we would like to book you for a wedding'

        ]);

        $Cancelled=Bookings::create([
            // 'username'=>'Super-Admin 1',
            'full_name'=>'Canceel Promoters',
            'location'=>'Nairobi',
            'phone'=>'0792492584',
            'is_booking'=>3,
            'email'=>'Werupromoter@admin.com',
            'date'=>'07/02/2021',
            'event_id'=>'4',
            'event_details'=>'we would like to book you for a wedding',

        ]);

        $Published=Bookings::create([
            'full_name'=>'Steven Promoters',
            'location'=>'Nairobi',
            'phone'=>'0792492584',
            'is_booking'=>4,
            'email'=>'Werupromoter@admin.com',
            'date'=>'07/02/2021',
            'event_id'=>'5',
            'event_details'=>'we would like to book you for a wedding'

        ]);
        $Approved->bookingstatus()->attach($Approvedstatus);
        $Cancelled->bookingstatus()->attach($Cancelledstatus);
        $DepositPaid->bookingstatus()->attach($DepositPaidstatus);
        $Published->bookingstatus()->attach($Publishedstatus);



        $fullpackage=Bookingpackage::where(['package_name'=>'Dj and Full Sound System',
                                            'package_description'=>'Dj and Full Sound System.Dj and Full Sound System',
                                            'package_price'=>'sh 80,000'])->first();
    
        $fullsetpackage=Bookings::create([
            'full_name'=>'Best Promoters',
            'location'=>'Nairobi',
            'phone'=>'0792492584',
            'is_booking'=>2,
            'package_id'=>'1',
            'email'=>'Werupromoter@admin.com',
            'date'=>'07/02/2021',
            'event_id'=>'5',
            'event_details'=>'we would like to book you for a wedding'

        ]);
        
        $fullsetpackage->bookingpack()->attach($fullpackage);
    }
}
