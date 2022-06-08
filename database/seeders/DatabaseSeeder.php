<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Merchadise;
use App\Models\Ticketstatus;
use App\Models\Bookingstatus;
use App\Models\bookingpackage;
use Illuminate\Database\Seeder;
use App\Models\Merchadisestatus;
use Database\Seeders\RoleSeeder;
use Database\Seeders\Userseeder;
use App\Models\Merchadisecategory;
use Database\Seeders\couponSeeder;
use Database\Seeders\EventsSeeder;
use Database\Seeders\BlogpostSeeder;
use Database\Seeders\BookingsSeeder;
use Database\Seeders\MerchadiseSeeder;
use Database\Seeders\TicketstatusSeeder;
use Database\Seeders\BookingstatusSeeder;
use Database\Seeders\paymentmethodSeeder;
use Database\Seeders\BlogcategoriesSeeder;
use Database\Seeders\BookingpackageSeeder;
use Database\Seeders\MerchadisestatusSeeder;
use Database\Seeders\BookingcategoriesSeeder;
use Database\Seeders\MerchadisecategorySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(couponSeeder::class);
        
        $this->call(BlogpostSeeder::class);

        $this->call([
            RoleSeeder::class,
            Userseeder::class,
        ]);
        \App\Models\Role::factory()->hasUsers(7)->create();

        $this->call([
            BookingpackageSeeder::class,
            BookingsSeeder::class,
        ]);
        \App\Models\bookingpackage::factory()->hasbookingpackags(7)->create();
        
        $this->call([
            BookingsSeeder::class,
            BookingstatusSeeder::class,
        ]);
        \App\Models\Bookingstatus::factory()->hasbookings(7)->create();

        $this->call([
            TicketstatusSeeder::class,
            EventsSeeder::class,
        ]);
        \App\Models\Ticketstatus::factory()->hasevents(7)->create();

        $this->call(BlogcategoriesSeeder::class);

        $this->call(BookingcategoriesSeeder::class);

        $this->call(MerchadisecategorySeeder::class);

        $this->call(ProductattributeSeeder::class);

        $this->call(paymentmethodSeeder::class);

    }
}
