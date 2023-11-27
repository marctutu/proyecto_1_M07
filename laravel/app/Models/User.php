<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Filament\Models\Contracts\FilamentUser;

class User extends Authenticatable implements FilamentUser
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
        'role_id',
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

    public function posts()
    {
        return $this->hasMany(Post::class, 'author_id');
    }	
    
    public function places()
    {
        return $this->hasMany(Place::class, 'author_id');
    }

    public function likes()
    {
        return $this->belongsToMany(Post::class, 'likes');
    }	

    public function favorites()
    {
        return $this->belongsToMany(Place::class, 'favorites');
    }

    public function canAccessFilament() : bool
    {
        return true;
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
 



}
