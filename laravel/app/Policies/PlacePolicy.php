<?php

namespace App\Policies;

use App\Models\Place;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PlacePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Place $place): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isPublisher();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Place $place): bool
    {
        return ($user->isPublisher() && $place->author_id === $user->id)
            || $user->isEditor();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Place $place): bool
    {
        return $user->isPublisher() && $place->author_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Place $place): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Place $place): bool
    {
        //
    }

    /**
     * Determine whether the user can favorite the model.
     */
    public function favorite(User $user, Place $place): bool
    {
        return $user->isPublisher() && !$place->favoritedByUser($user);
    }

    /**
     * Determine whether the user can unfavorite the model.
     */
    public function unfavorite(User $user, Place $place): bool
    {
        return $user->isPublisher() && $place->favoritedByUser($user);
    }
}
