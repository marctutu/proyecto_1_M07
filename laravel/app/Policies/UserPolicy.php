<?php
namespace App\Policies;

use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->role->name === 'admin';
    }

    public function view(User $user, User $model)
    {
        return $user->role->name === 'admin';
    }

    public function create(User $user)
    {
        return $user->role->name === 'admin';
    }

    public function update(User $user, User $model)
    {
        return $user->role->name === 'admin';
    }

    public function delete(User $user, User $model)
    {
        return $user->role->name === 'admin';
    }
}
