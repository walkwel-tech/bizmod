<?php

namespace App\Policies;

use App\Code;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CodePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return in_array('view-codes', $user->permissions);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Code  $code
     * @return mixed
     */
    public function view(User $user, Code $code)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Code  $code
     * @return mixed
     */
    public function update(User $user, Code $code)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Code  $code
     * @return mixed
     */
    public function delete(User $user, Code $code)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Code  $code
     * @return mixed
     */
    public function restore(User $user, Code $code)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Code  $code
     * @return mixed
     */
    public function forceDelete(User $user, Code $code)
    {
        //
    }
}
