<?php
namespace App\Policies;

use App\Models\Place;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PlacePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        // Tots poden llistar i visualitzar els places
        return true;
    }

    public function view(User $user, Place $place)
    {
        \Log::debug("Authorize view place");    
        // Tots poden veure els places individuals
        return true;
    }

    public function create(User $user)
    {
        // Només usuaris amb el rol "author" poden crear places
        return $user->role->name === 'author';
    }

    public function update(User $user, Place $place)
    {
        // "author" pot editar els seus propis places
        return $user->role->name === 'author' && $user->id === $place->author_id;
        // "author" pot editar els seus propis places i "editor" qualsevol place
        // return $user->role->name === 'author' && $user->id === $place->user_id || $user->role->name === 'editor';
    }

    public function delete(User $user, Place $place)
    {
        // "author" pot eliminar els seus propis places i "editor" qualsevol place
        return $user->role->name === 'author' && $user->id === $place->author_id || $user->role->name === 'editor';
    }
}
