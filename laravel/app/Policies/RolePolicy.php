<?php
namespace App\Policies;

use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->role->name === 'admin';
    }

    public function view(User $user, Role $role)
    {
        return $user->role->name === 'admin';
    }

    public function create(User $user)
    {
        return $user->role->name === 'admin';
    }

    public function update(User $user, Role $role)
    {
        return $user->role->name === 'admin';
    } 

    public function delete(User $user, Role $role)
    {
        return $user->role->name === 'admin';
    }
}
