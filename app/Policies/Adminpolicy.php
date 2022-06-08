<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class Adminpolicy
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

    public function accessAdmins(user $user){
        return $user->hasAnyRoles(['SuperAdmin','NormalAdmin']);
    }

    public function manageAdmins(user $user){
        return $user->hasAnyRoles(['SuperAdmin']);
    }
}
