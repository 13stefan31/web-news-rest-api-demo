<?php

namespace Database\Factories\Post\Model;

use App\Post\Model\Post;
use App\PostCategory\Model\PostCategory;
use App\User\Model\User;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'header_main' => $this->faker->text,
            'subheader' => $this->faker->text,
            'category' => $this->getRandomCategory(),
            'posts_content' =>$this->faker->text,
            'picture_links' => $this->faker->url."----".$this->faker->url,
            'owner' => $this->getRandomUser(),
            'recommended' => $this->faker->boolean(50),
            'is_active' => $this->faker->boolean(60),

        ];
    }

    private function getRandomUser()
    {
        return User::inRandomOrder()->select('id')->where('position', 'author')->first();
    }

    private function getRandomCategory()
    {
        return PostCategory::inRandomOrder()->first();
    }
}
