<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory, HasSEO;

    protected $fillable = [
        'body',
        'file_id',
        'latitude',
        'longitude',
        'author_id',
        'visibility_id'
    ];

    public function file()
    {
       return $this->belongsTo(File::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }
    
    public function liked()
    {
        return $this->belongsToMany(User::class, 'likes');
    }
    
    public function likedByUser(User $user)
    {
        $count = Like::where([
            ['user_id',  '=', $user->id],
            ['post_id', '=', $this->id],
        ])->count();
        
        return $count > 0;
    }

    public function likedByAuthUser()
    {
        $user = auth()->user();
        return $this->likedByUser($user);
    }

    public function visibility()
    {
        return $this->belongsTo(Visibility::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    use HasSEO;

    protected function getDynamicSEOData(): SEOData
    {
        $truncatedBody = Str::limit($this->body, 160); // Truncate the body to use as a description
    
        // Make sure the author relationship is loaded to prevent N+1 queries
        $authorName = $this->author->name ?? 'Marc Tutusaus Vilanova'; // Use 'name' from the User model
    
        return new SEOData(
            title: $truncatedBody,
            description: $truncatedBody,
            author: $authorName, // Here you use the author's name
        );
    }

}
