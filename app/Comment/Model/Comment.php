<?php

namespace App\Comment\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Post\Model\Post;
use App\User\Model\User;

class Comment extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
