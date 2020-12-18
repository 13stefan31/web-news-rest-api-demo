<?php

namespace App\Post\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\PostCategory\Model\PostCategory;
use App\User\Model\User;
use App\Comment\Model\Comment;

class Post extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    public function comment()
    {
        return $this->hasMany(Comment::class, 'post_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'owner');
    }

    public function category()
    {
        return $this->belongsTo(PostCategory::class, 'category');
    }
}
