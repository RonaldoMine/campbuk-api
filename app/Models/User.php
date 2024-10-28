<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'deleted_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the name of the user
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the email of the user
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the deleted_at of the user
     * @return mixed
     */
    public function getDeletedAt()
    {
        return $this->deleted_at;

    }

    /**
     * Get the email of the user
     * @return array
     */
    public function profile()
    {
        return [
            "email" => $this->email,
            "name" => $this->name
        ];
    }

    /**
     * List use's posts
     * @return array<Post>
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
