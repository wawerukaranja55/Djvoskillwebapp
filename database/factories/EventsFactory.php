<?php

namespace Database\Factories;

use App\Models\Events;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Events::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'is_ticket'=>0,
            'eve_name'=>$this->faker->unique()->name,
            'eve_location'=>$this->faker->address,
            'eve_time'=>$this->faker->time(),
            'eve_image'=>'eventimages/20210705132813.jpg',
            'eve_date'=>$this->faker->unique()->dateTime()->format('Y/m/d'),
            'eve_details'=>$this->faker->paragraphs(2, true),
        ];
    }
}
