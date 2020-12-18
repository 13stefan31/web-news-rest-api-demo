<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Comment\Model\Comment;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Comment::factory()->count(121)->create();
    }
}
