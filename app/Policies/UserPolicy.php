<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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

    public function save(User $user) {
        // dd($user->canDo('EDIT_MENU'));
        return $user->canDo('EDIT_USERS');
    }
    public function destroy(User $user) {
        // dd($user->canDo('EDIT_MENU'));
        return $user->canDo('EDIT_USERS');
    }
}
