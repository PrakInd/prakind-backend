<?php

namespace Database\Factories;

use App\Models\Application;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicantFileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $application_ids = Application::all()->pluck('id')->toArray();

        return [
            'application_id' => $this->faker->randomElement($application_ids),
            'recommendation_letter' => 'recommendation_letter.' . $this->faker->fileExtension(),
            'proposal' => 'proposal.' . $this->faker->fileExtension()
        ];
    }
}
