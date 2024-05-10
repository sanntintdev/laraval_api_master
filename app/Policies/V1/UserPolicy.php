<?php

namespace App\Policies\V1;

use App\Models\User;
use App\Permissions\V1\Abilities;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function delete(User $user, User $model)
    {
        return $user->tokenCan(Abilities::DeleteUser);
    }

    public function replace(User $user, User $model)
    {
        return $user->tokenCan(Abilities::ReplaceTicket);
    }

    public function store(User $user)
    {
        return $user->tokenCan(Abilities::CreateTicket);
    }

    public function update(User $user, User $model)
    {
        return $user->tokenCan(Abilities::UpdateUser);
    }
}
