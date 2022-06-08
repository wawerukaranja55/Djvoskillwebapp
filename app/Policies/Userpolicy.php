<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class Userpolicy
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

    public function accessUsers(user $user){
        return $user->hasAnyRoles(['SuperAdmin','NormalAdmin']);
    }

    public function manageUsers(user $user){
        return $user->hasAnyRoles(['SuperAdmin']);
    }
}
