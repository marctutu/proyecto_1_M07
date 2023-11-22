<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }


    public function file()
    {
        return $this->belongsTo(File::class);
    }   

    public function liked()
    {
        return $this->belongsToMany(User::class, 'likes');
    }


    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    protected $fillable = ['body', 'author_id', 'file_id', 'latitude', 'longitude'];
}
