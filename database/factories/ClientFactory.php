<?php

namespace Database\Factories;

use App\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Client::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => substr($this->faker->e164PhoneNumber, 1, 10),
            'country_name' => $this->faker->country,
            'country_code' => $this->faker->areaCode,
            'zip' => $this->faker->postcode,
        ];
    }
}
