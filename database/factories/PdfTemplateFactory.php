<?php

namespace Database\Factories;

use App\Helpers\TemplateConfiguration;
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
        $confg = new TemplateConfiguration(
            [
                'position' => ['x' => '10', 'y' => '20']
            ],
            [
                'position' => ['x' => '10', 'y' => '180']
            ],
        );


        return [
            'title' => $this->faker->unique()->word,
            'description' => $this->faker->paragraph,
            'path' => 'default.pdf',
            'configuration' => $confg,
        ];
    }
}
