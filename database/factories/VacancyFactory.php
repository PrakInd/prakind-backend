<?php

namespace Database\Factories;

use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class VacancyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $company_ids = Company::all()->pluck('id')->toArray();

        return [
            'company_id' => $this->faker->randomElement($company_ids),
            'name' => $this->faker->jobTitle(),
            'description' => $this->faker->sentence(),
            'requirements' => $this->faker->sentence(),
            'location' => $this->faker->city(),
            'sector' => $this->faker->jobTitle(),
            'type' => $this->faker->randomElement(['kerja_dari_kantor', 'kerja_dari_rumah']),
            'paid' => $this->faker->randomElement(['tersedia', 'tidak_tersedia']),
            'period_start' => Carbon::today()->subDays(rand(0, 365))->format('D, d M Y'),
            'period_end' => Carbon::today()->subDays(rand(0, 365))->format('D, d M Y')
        ];
    }
}
