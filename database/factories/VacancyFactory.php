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
            'description' => $this->faker->paragraph(),
            'requirements' => $this->faker->paragraph(),
            'location' => $this->faker->city(),
            'sector' => $this->faker->jobTitle(),
            'type' => $this->faker->randomElement(['online', 'offline']),
            'paid' => $this->faker->randomElement(['ya', 'tidak']),
            'period_start' => Carbon::today()->subDays(rand(0, 365))->format('D, d M Y'),
            'period_end' => Carbon::today()->subDays(rand(0, 365))->format('D, d M Y'),
        ];
    }
}
