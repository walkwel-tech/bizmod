<?php

namespace Database\Factories;

use App\Code;
use App\Client;
use App\PdfTemplate;
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
        $code_chk = $this->faker->boolean(50);

        $givenDate = $this->faker->dateTime();
        $claimDate = $this->faker->dateTimeBetween($givenDate);
        $expireDate = $this->faker->dateTimeBetween('+18 month','+19 month');

        return [
            'batch_no' => $this->faker->word,
            'code' => $this->faker->unique()->word,
            'client_id' => $code_chk ? Client::all()->random()->id : null,
            'claim_details' =>  $code_chk ? [
                "page_id" => $this->faker->randomNumber(),
                "location" => $this->faker->streetAddress,
                "country" => $this->faker->city,
                "zip" => $this->faker->postcode
            ] : null,

            'claimed_on' => $code_chk ?  $claimDate: null,
            'given_on' => $code_chk ? $givenDate : null,
            'expire_on' => $expireDate
        ];
    }
}
