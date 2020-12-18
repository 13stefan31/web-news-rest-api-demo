<?php

namespace Database\Seeders;

use App\Post\Model\Post;

use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::factory()->count(21)->create();
    }
}
