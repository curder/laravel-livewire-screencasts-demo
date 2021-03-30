<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

/**
 * Class User
 * @property string name
 * @property string email
 * @property string password
 * @property string birthday
 * @property string about
 * @property string avatar_url
 * @property string avatar
 *
 * @package App\Models
 */
class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'birthday',
        'about',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return string
     */
    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar ? Storage::disk('avatars')->url($this->avatar) : 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($this->email)));
    }
}
