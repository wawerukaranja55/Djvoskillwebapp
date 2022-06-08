<?php

namespace Database\Factories;

use App\Models\Blogpost;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogpostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Blogpost::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'=>$this->faker->unique()->numberBetween(1,50),
            'cat_id'=>$this->faker->numberBetween(1, 2),
            'blo_image'=>'post.PNG',
            'blo_details'=>$this->faker->paragraphs(2, true),
            'blo_title'=>$this->faker->unique(5)->company(),
        ];
    }
}
