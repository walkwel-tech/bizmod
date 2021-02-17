<?php

namespace Database\Factories;

use App\PdfTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;

class PdfTemplateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PdfTemplate::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->unique()->word,
            'description' => $this->faker->paragraph,
            'path' => 'default.pdf',
            'configuration' => [
                "business" => ['x'=>'10','y'=>'20'],
                "code" => ['x'=>'10','y'=>'180'],
                ]
        ];
    }
}
