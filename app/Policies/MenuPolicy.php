<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MenuPolicy
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
        return $user->canDo('EDIT_MENU');
    }

    public function destroy(User $user) {
        // dd($user->canDo('EDIT_MENU'));
        return $user->canDo('DESTROY_MENU');
    }
}
