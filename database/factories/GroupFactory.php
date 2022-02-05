<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'referral_code' => $this->faker->regexify('[A-Z]{7}[0-4]{5}')
        ];
    }
}
