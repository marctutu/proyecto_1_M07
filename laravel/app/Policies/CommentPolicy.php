<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comment;

class CommentPolicy
{
    public function view(User $user, Comment $comment)
    {
        // Aquí puedes colocar la lógica para determinar si el usuario puede ver el comentario
        return true; // Por ahora, dejaremos que todos los usuarios vean los comentarios
    }

    public function delete(User $user, Comment $comment)
    {
        // Aquí puedes colocar la lógica para determinar si el usuario puede eliminar el comentario
        return $user->isAdmin() || $user->id === $comment->user_id; // Por ahora, solo el usuario que creó el comentario puede eliminarlo
    }
}
