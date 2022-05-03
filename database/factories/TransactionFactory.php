<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {   
        return array(
            'title' => $this->faker->sentence(4, true),
            'value' => $this->faker->numberBetween(100, 10000),
            'type'  => $this->faker->randomElement(array('income', 'outcome', 'income'))
        );
    }
}
