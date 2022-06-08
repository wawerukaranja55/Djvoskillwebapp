<?php

namespace Database\Seeders;

use App\Models\Merchadise;
use Illuminate\Database\Seeder;
use App\Models\Merchadisecategory;
use App\Models\Merchadisestatus;

class MerchadiseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Merchadise::factory()->count(7)->create();
    }
}
