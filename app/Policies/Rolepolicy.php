<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class Rolepolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine whether the user can view the model
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\User $model
     * @return mixed
     */

    public function accessRoles(user $user){
        return $user->hasAnyRoles(['SuperAdmin','NormalAdmin']);
    }

    public function manageRoles(user $user){
        return $user->hasAnyRoles(['SuperAdmin']);
    }
}
