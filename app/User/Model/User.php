<?php

namespace App\User\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\UserRole\Model\UserRole;
use App\Post\Model\Post;
use App\Comment\Model\Comment;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory;
    use Notifiable;

    const UPDATED_AT = null;

    public function role()
    {
        return $this->belongsTo(UserRole::class, 'position');
    }

    public function post()
    {
        return $this->hasMany(Post::class, 'owner');
    }

    public function comment()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    public function getJWTIdentifier()
    {

        return $this->getKey();

    }


    public function getJWTCustomClaims(): array
    {

        return [];

    }

//    public function is_admin()
//    {
//        $this->
//    }
}
