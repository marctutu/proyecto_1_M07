<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = ['filepath', 'filesize'];

    // Agrega esta función para definir la relación inversa
    public function post()
    {
        // Suponiendo que el nombre de la clave foránea en la tabla posts es 'file_id'
        return $this->hasOne(Post::class, 'file_id');
    }
}
