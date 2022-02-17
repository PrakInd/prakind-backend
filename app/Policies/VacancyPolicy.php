<?php

namespace App\Policies;

use App\Models\Roles;
use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Auth\Access\HandlesAuthorization;

class VacancyPolicy
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
        return $user->role_id == Roles::IS_ADMIN;
    }

    public function update(User $user, Vacancy $vacancy)
    {
        return $user->role_id == Roles::IS_ADMIN;
    }

    public function delete(User $user, Vacancy $vacancy)
    {
        return $user->role_id == Roles::IS_ADMIN;
    }
}
