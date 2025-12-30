<?php

namespace App\Policies;

use App\Models\Ujian;
use App\Models\User;

class UjianPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isGuru();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Ujian $ujian): bool
    {
        // Guru can only view their own ujian
        return $user->guru && $ujian->guru_id === $user->guru->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isGuru();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Ujian $ujian): bool
    {
        // Guru can only update their own ujian
        return $user->guru && $ujian->guru_id === $user->guru->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Ujian $ujian): bool
    {
        // Guru can only delete their own ujian
        return $user->guru && $ujian->guru_id === $user->guru->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Ujian $ujian): bool
    {
        return $user->guru && $ujian->guru_id === $user->guru->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Ujian $ujian): bool
    {
        return $user->guru && $ujian->guru_id === $user->guru->id;
    }
}
