<?php

namespace App\Policies;

use App\Models\Assignment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AssignmentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Assignment $assignment): bool
    {
        return $user->user_id === $assignment->instructor_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Assignment $assignment): bool
    {
        return $user->user_id === $assignment->instructor_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Assignment $assignment): bool
    {
        return $user->user_id === $assignment->instructor_id;
    }
}
