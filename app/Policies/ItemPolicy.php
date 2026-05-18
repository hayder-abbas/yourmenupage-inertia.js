<?php

namespace App\Policies;

use App\Models\Item;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ItemPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return $user->can('viewAny', Item::class)
            ? Response::allow()
            : Response::deny("You are not authorized to view any item");
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Item $item): Response
    {
        return $user->id === $item->user_id
            ? Response::allow()
            : Response::deny("You are not authorized to view this item");
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->can('create', Item::class)
            ? Response::allow()
            : Response::deny("You are not authorized to create this item");
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Item $item): Response
    {
        return $user->id === $item->user_id
            ? Response::allow()
            : Response::deny("You are not authorized to update this item");
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Item $item): Response
    {
        return $user->id === $item->user_id
            ? Response::allow()
            : Response::deny("You are not authorized to delete this item");
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Item $item): Response
    {
        return $user->id === $item->user_id
            ? Response::allow()
            : Response::deny("You are not authorized to restore this item");
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Item $item): Response
    {
        return $user->id === $item->user_id
            ? Response::allow()
            : Response::deny("You are not authorized to permanently delete this item");
    }
}
