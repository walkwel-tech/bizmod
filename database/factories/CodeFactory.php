<?php

namespace Database\Factories;

use App\Code;
use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CodeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Code::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'batch_no' => $this->faker->word,
            'code' => $this->faker->word,
            'claim_details' => [
                "page_id" => $this->faker->randomNumber(),
                "location" => $this->faker->streetAddress,
                "country" => $this->faker->city,
                "zip" => $this->faker->postcode
            ],

            'claimed_on' => $this->faker->dateTime()
        ];
    }
}
