<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'=>$this->faker->sentence(4),
            'slug'=>$this->faker->slug,
            'content'=>$this->faker->paragraph(3,true),
//            'category_id'=>Category::factory(),
//            'user_id'=>User::factory(),
        ];
    }
}
