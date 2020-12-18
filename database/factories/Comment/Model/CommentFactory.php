<?php

namespace Database\Factories\Comment\Model;

use App\Comment\Model\Comment;
use App\Post\Model\Post;
use App\User\Model\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "user_id" => $this->getRandomUser(),
            "post_id" => $this->getRandomPost(),
            "content" => $this->faker->text,
            "comment_votes" => $this->faker->randomNumber(),
            "created_at" => $this->faker->dateTime,
        ];
    }

    private function getRandomUser()
    {
        return User::inRandomOrder()->select('id')->where('position', 'visitor')->first();
    }

    private function getRandomPost()
    {
        return Post::inRandomOrder()->first();
    }
}
