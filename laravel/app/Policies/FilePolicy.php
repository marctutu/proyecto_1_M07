<?php

namespace App\Policies;

use App\Models\File;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FilePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->role->name === 'admin';
    }

    public function view(User $user, File $file): bool
    {
        return $user->role->name === 'admin';
    }

    public function create(User $user): bool
    {
        return $user->role->name === 'admin';
    }

    public function update(User $user, File $file): bool
    {
        return $user->role->name === 'admin';
    }

    public function delete(User $user, File $file): bool
    {
        return $user->role->name === 'admin';
    }
}
