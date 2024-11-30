<?php

namespace App\Entity;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function getInfo()
    {
        return $this->hasOne(UserInfo::class, 'user_id', 'id')->get()?
            $this->hasOne(UserInfo::class, 'user_id', 'id')->get()[0]
            :[];
    }

    public function getDocument()
    {
        return $this->hasOne(UserDocumet::class, 'user_id', 'id')->get()?
            $this->hasOne(UserDocumet::class, 'user_id', 'id')->get()[0]
            :[];
    }
}
