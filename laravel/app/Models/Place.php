<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use Illuminate\Support\Str;


class Place extends Model
{
    use HasFactory, HasSEO;
    
    protected $fillable = [
        'name',
        'description',
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
    
    public function favorited()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }
    
    public function favoritedByUser(User $user)
    {
        $count = Favorite::where([
            ['user_id',  '=', $user->id],
            ['place_id', '=', $this->id],
        ])->count();

        return $count > 0;
    }

    public function favoritedByAuthUser()
    {
        $user = auth()->user();
        return $this->favoritedByUser($user);
    }

    public function visibility()
    {
        return $this->belongsTo(Visibility::class);
    }

    use HasSEO;

    protected function getDynamicSEOData(): SEOData
    {
        $title = $this->name; // Usa el campo 'name' como título SEO
        $description = Str::limit($this->description, 160); // Usa el campo 'description' como descripción SEO, truncado a 160 caracteres
        
        // Asegura cargar la relación con author para evitar consultas N+1
        $authorName = $this->author->name ?? 'Marc Tutusaus Vilanova'; 

        return new SEOData(
            title: $title,
            description: $description,
            author: $authorName,
        );
    }
}
