<?php

namespace App\Models;

use Illuminate\Support\Facades\Date; // Add this line

// use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        'two_factor_code', 
        'two_factor_expires_at',
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
        'password' => 'hashed',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likedComments()
    {
        return $this->belongsToMany(Comment::class, 'comment_user');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function likedPosts()
    {
        return $this->belongsToMany(Post::class, 'likes', 'user_id', 'post_id');
    }


    public function isSubscribedTo($subpage)
    {
        return $this->subscriptions()->where('subpage_id', $subpage->id)->exists();
    }

    public function subscriptions()
    {
        return $this->belongsToMany(Subpage::class, 'subscriptions', 'user_id', 'subpage_id');
    }

    
    public function ownedSubpages() {
        return $this->hasMany(Subpage::class, 'owner_id');
    }

    public function generateTwoFactorCode(): void
    {
        $this->timestamps = false;  
        $this->two_factor_code = rand(1, 99);  
        $this->two_factor_expires_at = Date::now()->addMinutes(10);  
        $this->save();
    }

    public function resetTwoFactorCode(): void
    {
    $this->timestamps = false;
    $this->two_factor_code = null;
    $this->two_factor_expires_at = null;
    $this->save();
    }
 }