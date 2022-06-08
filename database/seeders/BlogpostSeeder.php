<?php

namespace Database\Seeders;

use App\Models\Blogpost;
use Illuminate\Database\Seeder;

class BlogpostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Blogpost::factory()->count(7)->create();
    }
}
