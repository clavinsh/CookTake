<?php

namespace App\Policies;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RecipePolicy
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

    public function update(User $user, Recipe $recipe)
    {
        return $user->id === $recipe->user_id;
    }

    public function delete(User $user, Recipe $recipe)
    {
        return $user->id === $recipe->user_id;
    }
}
