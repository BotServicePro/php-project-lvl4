<?php

namespace App\Policies;

use App\Models\Label;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class LabelPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function viewAny(?User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Label $label
     * @return Response|bool
     */
    public function view(?User $user, Label $label)
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function create(User $user)
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Label $label
     * @return Response|bool
     */
    public function update(User $user, Label $label)
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Label $label
     * @return Response|bool
     */
    public function delete(User $user, Label $label)
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Label $label
     * @return Response|bool
     */
    public function restore(User $user, Label $label)
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Label $label
     * @return Response|bool
     */
    public function forceDelete(User $user, Label $label)
    {
        return Auth::check();
    }
}
