<?php

namespace Database\Factories;

use App\Models\Certificate;
use App\Models\Group;
use App\Models\Profile;
use App\Models\Vacancy;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $profile_ids = Profile::all()->pluck('id')->toArray();
        $group_ids = Group::all()->pluck('id')->toArray();
        $vacancy_ids = Vacancy::all()->pluck('id')->toArray();
        // $certificate_ids = Certificate::all()->pluck('id')->toArray();

        return [
            'profile_id' => $this->faker->unique()->randomElement($profile_ids),
            'group_id' => $this->faker->randomElement($group_ids),
            'vacancy_id' => $this->faker->randomElement($vacancy_ids),
            // 'certificate_id' => $this->faker->randomElement($certificate_ids),
            'status' => $this->faker->randomElement(['in_selection', 'accepted', 'declined', 'taken', 'not_taken']),
            'certificate' => $this->faker->fileExtension(),
            'period_start' => Carbon::today()->subDays(rand(0, 365))->format('D, d M Y'),
            'period_end' => Carbon::today()->subDays(rand(0, 365))->format('D, d M Y'),
        ];
    }
}
