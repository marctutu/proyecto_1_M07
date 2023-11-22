<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'file_id',
        'latitude',
        'longitude',
        'author_id',
    ];

    protected $table = 'places';
    // Aquí puedes definir las relaciones con otros modelos, como File o User
    public function file()
    {
        return $this->belongsTo(File::class);
    }

    public function favorited()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }


    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // Añade otros métodos que puedas necesitar para tu lógica de negocio
}

