<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserToUserLikes extends Model {

    protected $table = 'user_to_user_likes';
    protected $fillable = ['owner_id', 'target_id'];

}
