<?php

namespace App\Policies;

use App\Models\{User, Setores};

class SetoresPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function edit(User $user, Setores $setor): bool
    {
        return $user
            ->roles()
            ->where('name', 'admin')
            ->exists();
    }

    public function destroy(User $user, Setores $setor): bool
    {
        return $user
            ->roles()
            ->where('name', 'admin')
            ->exists();
    }
}