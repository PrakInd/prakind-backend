<?php

namespace App\Policies;

use App\Models\Application;
use App\Models\Profile;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApplicationPolicy
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

    public function create(User $user)
    {
        return $user->role_id == Roles::IS_PELAMAR;
    }

    public function update(User $user, Application $application, Profile $profile)
    {
        return $user->role_id == Roles::IS_PELAMAR;
    }

    public function delete(User $user) {
        return $user->role_id == Roles::IS_PELAMAR;
    }
}
