<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PortfolioPolicy
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

    public function add(User $user){
        return $user->canDo('EDIT_PORTFOLIOS');
    }

    public function save(User $user){
        return $user->canDo('EDIT_PORTFOLIOS');
    }

    public function edit(User $user){
        return $user->canDo('EDIT_PORTFOLIOS');
    }
}
