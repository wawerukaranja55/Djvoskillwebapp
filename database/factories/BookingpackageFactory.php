<?php

namespace Database\Factories;

use App\Models\Bookingpackage;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingpackageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bookingpackage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'package_name'=>'Dj Only',
            'package_description'=>'In this package the dj will only provide a service of playing music only.
                                    Thus he will come with his laptop and machine player to the venue,and any other necessary detail required to deliver the service perfectly',
            'package_price'=>'sh 50,000'
        ];
    }
}
