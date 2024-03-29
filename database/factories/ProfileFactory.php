<?php

namespace Database\Factories;

use App\Models\Institution;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $institution_ids = Institution::all()->pluck('id')->toArray();
        $user_ids = User::where('role_id', 2)->pluck('id')->toArray();

        return [
            'user_id' => $this->faker->randomElement($user_ids),
            'institution_id' => $this->faker->randomElement($institution_ids),
            'address' => $this->faker->address(),
            'phone' => $this->faker->phoneNumber(),
            'gpa' => $this->faker->randomFloat(2, 0, 4),
            'semester' => $this->faker->randomElement(['1', '2', '3', '4', '5', '6', '7', '8']),
            'cv' => 'cv.' . $this->faker->fileExtension(),
            'transcript' => 'transcript.' . $this->faker->fileExtension(),
            'portfolio' => 'portfolio.' . $this->faker->fileExtension()
        ];
    }
}
