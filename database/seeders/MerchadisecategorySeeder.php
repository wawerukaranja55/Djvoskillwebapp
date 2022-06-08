<?php

namespace Database\Seeders;

use App\Models\Merchadisecategory;
use Illuminate\Database\Seeder;

class MerchadisecategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $merchadisecategories=[
            ['id'=>1,'section_id'=>'1','merchadisecat_title'=>'Tshirts','url'=>'t-shirts','category_discount'=>'10'],
            ['id'=>2,'section_id'=>'2','merchadisecat_title'=>'Tops','url'=>'tops','category_discount'=>'5'],
            ['id'=>3,'section_id'=>'2','merchadisecat_title'=>'Sweat pants','url'=>'sweat-pants','category_discount'=>'20'],
            ['id'=>4,'section_id'=>'4','merchadisecat_title'=>'Kitchen Utensils','url'=>'Kitchen-utensils','category_discount'=>'7']
            
        ];

        Merchadisecategory::insert($merchadisecategories);
    }
}
