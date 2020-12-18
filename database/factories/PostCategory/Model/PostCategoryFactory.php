<?php

namespace Database\Factories\PostCategory\Model;

use App\PostCategory\Model\PostCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PostCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_name' =>$this->faker->unique()->randomElement(['football', 'basketball', 'tennis', 'boxing', 'other']),
        ];
    }
}
