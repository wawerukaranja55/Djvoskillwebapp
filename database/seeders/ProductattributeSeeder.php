<?php

namespace Database\Seeders;

use App\Models\Productattribute;
use Illuminate\Database\Seeder;

class ProductattributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productattibutesrecords=[
            ['id'=>1,'product_id'=>1,'productattr_size'=>'Small','productattr_price'=>'500','productattr_stock'=>10,'productattr_sku'=>'H01-S','productattr_status'=>0],
            ['id'=>2,'product_id'=>1,'productattr_size'=>'Medium','productattr_price'=>'700','productattr_stock'=>8,'productattr_sku'=>'H01-M','productattr_status'=>0],
            ['id'=>3,'product_id'=>1,'productattr_size'=>'Large','productattr_price'=>'1000','productattr_stock'=>5,'productattr_sku'=>'H01-L','productattr_status'=>0],
            ['id'=>4,'product_id'=>1,'productattr_size'=>'Extra_Large','productattr_price'=>'1200','productattr_stock'=>7,'productattr_sku'=>'H01-Xl','productattr_status'=>0]
        ];

        Productattribute::insert($productattibutesrecords);
    }
}
