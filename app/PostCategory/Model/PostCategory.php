<?php

namespace App\PostCategory\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Post\Model\Post;

class PostCategory extends Model
{
    use HasFactory;

    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected $table = 'categories';

    public function posts()
    {
        return $this->hasMany(Post::class, 'category');
    }

}
