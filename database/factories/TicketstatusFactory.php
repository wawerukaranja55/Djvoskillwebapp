<?php

namespace Database\Factories;

use App\Models\Ticketstatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketstatusFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ticketstatus::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'ticket_type'=>'Free Entry'
        ];
    }
}
