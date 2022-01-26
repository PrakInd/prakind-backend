<?php

namespace Database\Factories;

use App\Models\Vacancy;
use Illuminate\Database\Eloquent\Factories\Factory;

class CertificateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $vacancy_ids = Vacancy::all()->pluck('id')->toArray();

        return [
            'vacancy_id' => $this->faker->randomElement($vacancy_ids),
            'certificate' => $this->faker->fileExtension()
        ];
    }
}
