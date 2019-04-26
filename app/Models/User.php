<?php

namespace App\Models;

use Carbon\Carbon;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\Token;

class User extends Authenticatable {

    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token', 'email_verified_at', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['email_verified_at' => 'datetime'];

    protected $appends = ['registration_date'];

    public function getRegistrationDateAttribute() {
        return strtolower(Carbon::createFromDate($this->attributes['created_at'])->format('m M Y'));
    }

    public function getToken(): \Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany(Token::class);
    }

    public function getLikes(): \Illuminate\Database\Eloquent\Relations\BelongsToMany {
        return $this->belongsToMany(self::class, (new UserToUserLikes())->getTable(), 'owner_id', 'id');
    }
}
