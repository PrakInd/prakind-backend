<?php

namespace Database\Factories;

use App\Models\Institution;
use Illuminate\Database\Eloquent\Factories\Factory;

class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $institution_ids = Institution::all()->pluck('id')->toArray();

        return [
            'institution_id' => $this->faker->randomElement($institution_ids),
            'name' => $this->faker->jobTitle()
        ];
    }
}
