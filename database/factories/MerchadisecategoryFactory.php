<?php

namespace Database\Factories;

use App\Models\Merchadisecategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class MerchadisecategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Merchadisecategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // 'merchadisecat_title'=>'Hoodies'
        ];
    }
}
