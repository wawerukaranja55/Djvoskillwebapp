<?php

namespace Database\Seeders;

use App\Models\coupon;
use Illuminate\Database\Seeder;

class couponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $coupons=[
            ['id'=>1,'coupon_code'=>'waweru99','coupon_option'=>'Automatic','coupon_type'=>'Single','amount_type'=>'Fixed','amount'=>'1000','users'=>'stephewaweru@gmail.com,waweru99@gmail.com','categories'=>'2,3','expiry_date'=>'2022.8.20','status'=>'0'],
            ['id'=>2,'coupon_code'=>'wawer23','coupon_option'=>'Automatic','coupon_type'=>'Single','amount_type'=>'Fixed','amount'=>'1000','users'=>'stephewaweru@gmail.com,waweru99@gmail.com','categories'=>'2,3','expiry_date'=>'2022.8.20','status'=>'0'],
            ['id'=>3,'coupon_code'=>'waw44','coupon_option'=>'Automatic','coupon_type'=>'Single','amount_type'=>'Fixed','amount'=>'1000','users'=>'stephewaweru@gmail.com,waweru99@gmail.com','categories'=>'2,3','expiry_date'=>'2022.8.20','status'=>'0'],
        ];

        coupon::insert($coupons);
    }
}
