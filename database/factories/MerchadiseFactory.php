<?php

namespace Database\Factories;

use App\Models\Merchadise;
use Illuminate\Database\Eloquent\Factories\Factory;

class MerchadiseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Merchadise::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            $merchnme='merch_name'=>$this->faker->unique(5)->name(),
            'url'=>$this->faker->unique(5)->company(),
            'merch_code'=>$this->faker->numerify('merch-####'),
            'merch_price'=>$this->faker->numberBetween(100, 150),
            'merch_image'=>$this->faker->image('public/images/productimages/medium/',520,600,$merchnme,null, false),
            'merch_video'=>'product.mp4',
            'merch_isactive'=>1,
            'stock'=>$this->faker->numberBetween(1, 10),
            'merchcat_id'=>$this->faker->numberBetween(1, 4),
            'merch_details'=>$this->faker->paragraphs(2, true),
            'product_discount'=>$this->faker->numberBetween(0,50),
            'meta_name'=>$this->faker->unique()->name,
            'meta_description'=>$this->faker->sentence(2),
            'fabric'=>$this->faker->randomElement(['cotton','leather']),
            'occasion'=>$this->faker->randomElement(['nightparty','office']),
            'meta_keywords'=>$this->faker->unique()->name,
            'is_attribute'=>0,
            'is_featured'=>'No',
        ];
    }
}
