<?php

namespace Database\Factories;

use App\Field;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class FieldFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Field::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word,
            'name' => $this->faker->word,
            'type' =>  $this->faker->randomElement(['text', 'textarea','select', 'radio','checkbox']),
            'mapped_to' => $this->faker->word,
            'placeholder' => $this->faker->word,
            'required' => 0,
            'validations' => $this->faker->word

        ];
    }
}
