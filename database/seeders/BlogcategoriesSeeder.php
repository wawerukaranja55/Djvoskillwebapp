<?php

namespace Database\Seeders;

use App\Models\Blogcategory;
use Illuminate\Database\Seeder;

class BlogcategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $blogcategories=[
            ['id'=>1,'blogcat_title'=>'Trending News'],
            ['id'=>2,'blogcat_title'=>'Latest and Upcoming Music']
        ];

        Blogcategory::insert($blogcategories);
    }
}
