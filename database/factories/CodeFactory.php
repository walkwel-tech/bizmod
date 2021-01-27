<?php

namespace Database\Factories;

use App\Code;
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
            'claim_details' => json_encode([
                "page_id" => $this->faker->randomNumber(),
                "location" => $this->faker->word,
                "city" => $this->faker->word,
                "zip" => $this->faker->word
            ]),

            'claimed_on' => $this->faker->dateTime()
        ];
    }
}