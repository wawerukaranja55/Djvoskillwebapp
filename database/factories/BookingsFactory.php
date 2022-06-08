<?php

namespace Database\Factories;

use App\Models\Bookings;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bookings::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'is_booking'=>0,
            'package_id'=>0,
            'full_name'=>$this->faker->unique()->name,
            'location'=>$this->faker->address,
            'phone'=>$this->faker->numerify('###-###-####'),
            'email'=>$this->faker->safeEmail,
            'date'=>$this->faker->unique()->dateTime()->format('Y/m/d'),
            'event_id'=>$this->faker->numberBetween(1, 6),
            'event_details'=>$this->faker->paragraphs(2, true),
            
        ];
    }
}
