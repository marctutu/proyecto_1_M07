<?php
namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        // Tots poden llistar i visualitzar els posts
        return true;
    }

    public function view(User $user, Post $post)
    {
        // Tots poden veure els posts individuals
        return true;
    }

    public function create(User $user)
    {
        // Només usuaris amb el rol "author" poden crear posts
        return $user->role->name === 'author';
    }

    public function update(User $user, Post $post)
    {
        // "author" pot editar els seus propis posts
        return $user->role->name === 'author' && $user->id === $post->author_id;
        // "author" pot editar els seus propis posts i "editor" qualsevol post
        // return $user->role->name === 'author' && $user->id === $post->user_id || $user->role->name === 'editor';
    }

    public function delete(User $user, Post $post)
    {
        // "author" pot eliminar els seus propis posts i "editor" qualsevol post
        return $user->role->name === 'author' && $user->id === $post->author_id || $user->role->name === 'editor';
    }

    public function like(User $user, Post $post)
    {
        //Només els usuaris amb rol "author" poden donar "like" als posts
        return $user->role->name === 'author';
    }

    public function unlike(User $user, Post $post)
    {
        // Només els usuaris amb rol "author" poden donar "unlike" als posts
        return $user->role->name === 'author';
    }
}
