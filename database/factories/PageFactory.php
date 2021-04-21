<?php

namespace Database\Factories;

use App\Page;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Page::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => 'Welcome',
            'content' => '<div class="content container-fluid">
            <div class="row justify-content-sm-center text-center py-10" style="background-color: #5e72e452 ;
        padding: 50px;
        margin: 70px 0;
        text-align: center;
        border-radius: 10px;">
                <div class="col-sm-9 col-md-7">
                    <img class="img-fluid mb-5" src="{% user_avatar %}" alt="Image Description" style="height: 100px;
        width: 100px;
        border-radius: 50%;">

                    <h1>Hello {% user_name %}</h1>
                    <h3>Nice to see you!</h3>
                    <p>You are now minutes away from managing businesses than ever before. Enjoy!</p>

                    <a class="btn btn-primary" href="#">Get started</a>
                </div>
            </div>
            <div class="row justify-content-sm-center text-center py-10">
                <div class="col-sm-9 col-md-7">
                    <h1>Manage Business and code</h1>
                    <p>Discover in the video , How to generate pdf batch and pdf templates</p>

                    <iframe style="width:100%" width="100%" height="315" src="https://www.youtube.com/embed/zckH4xalOns"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen=""></iframe>
                </div>
            </div>
        </div>'
        ];
    }
}
