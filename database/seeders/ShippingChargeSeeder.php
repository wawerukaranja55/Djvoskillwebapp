<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\shipping_charge;

class ShippingChargeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shippingcharges=[
            ['id'=>1,'county'=>'Mombasa'],
            ['id'=>2,'county'=>'Kwale'],
            ['id'=>3,'county'=>'Kilifi'],
            ['id'=>4,'county'=>'Tana River'],
            ['id'=>5,'county'=>'Lamu'],
            ['id'=>6,'county'=>'Taita-Taveta'],
            ['id'=>7,'county'=>'Garrisa'],
            ['id'=>8,'county'=>'Wajir'],
            ['id'=>9,'county'=>'Mandera'],
            ['id'=>10,'county'=>'Marsabit'],
            ['id'=>11,'county'=>'Isiolo'],
            ['id'=>12,'county'=>'Meru'],
            ['id'=>13,'county'=>'Tharaka-Nithi'],
            ['id'=>14,'county'=>'Embu'],
            ['id'=>15,'county'=>'Kitui'],
            ['id'=>16,'county'=>'Machakos'],
            ['id'=>17,'county'=>'Makueni'],
            ['id'=>18,'county'=>'Nyandarua'],
            ['id'=>19,'county'=>'Nyeri'],
            ['id'=>20,'county'=>'Kirinyaga'],
            ['id'=>21,'county'=>'Muranga'],
            ['id'=>22,'county'=>'Kiambu'],
            ['id'=>23,'county'=>'Turkana'],
            ['id'=>24,'county'=>'West Pokot'],
            ['id'=>25,'county'=>'Samburu'],
            ['id'=>26,'county'=>'Trans Nzoia'],
            ['id'=>27,'county'=>'Uasin Gishu'],
            ['id'=>28,'county'=>'Elgeyo-Marakwet'],
            ['id'=>29,'county'=>'Nandi'],
            ['id'=>30,'county'=>'Baringo'],
            ['id'=>31,'county'=>'Laikipia'],
            ['id'=>32,'county'=>'Nakuru'],
            ['id'=>33,'county'=>'Narok'],
            ['id'=>34,'county'=>'Kajiado'],
            ['id'=>35,'county'=>'Kericho'],
            ['id'=>36,'county'=>'Bomet'],
            ['id'=>37,'county'=>'Kakamega'],
            ['id'=>38,'county'=>'Vihiga'],
            ['id'=>39,'county'=>'Bungoma'],
            ['id'=>40,'county'=>'Busia'],
            ['id'=>41,'county'=>'Siaya'],
            ['id'=>42,'county'=>'Kisumu'],
            ['id'=>43,'county'=>'Homa Bay'],
            ['id'=>44,'county'=>'Migori'],
            ['id'=>45,'county'=>'Kisii'],
            ['id'=>46,'county'=>'Nyamira'],
            ['id'=>47,'county'=>'Nairobi City']
        ];

        shipping_charge::insert($shippingcharges);
    }
}
