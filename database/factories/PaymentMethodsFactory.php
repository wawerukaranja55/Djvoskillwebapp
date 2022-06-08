<?php

namespace Database\Factories;

use App\Models\payment_methods;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentMethodsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = payment_methods::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
        ];
    }
}
