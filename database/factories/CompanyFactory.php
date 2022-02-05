<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => function (array $attributes) {
                return User::factory()->create([
                    'role_id' => 1
                ]);
            },
            'name' => $this->faker->unique()->name(),
            'description' => $this->faker->sentence(),
            'address' => $this->faker->address(),
            'phone' => $this->faker->phoneNumber(),
            'website' => $this->faker->domainName(),
            'number_of_employee' => $this->faker->numberBetween(0, 200),
            'logo' => $this->faker->imageUrl(640, 640)
        ];
    }
}
