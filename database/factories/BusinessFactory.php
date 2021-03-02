<?php

namespace Database\Factories;

use App\Business;
use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BusinessFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Business::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'prefix' => strtoupper(substr($this->faker->word(), 0, 3)),
            'owner_id' => User::all()->random()->id,
            'threshold' => $this->faker->unique()->randomDigit,
            'webhook_url' => 'https://webhook.site/db53fcf1-7073-4c79-b13b-cac2f9d8a743'
        ];
    }
}
