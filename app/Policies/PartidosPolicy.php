<?php

// Policy dos dados do VideoWall

namespace App\Policies;

use App\Models\{User, Partidos};

class PartidosPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function edit(User $user, Partidos $partido): bool
    {
        return $user
            ->roles()
            ->where('name', 'admin')
            ->exists();
    }

    public function destroy(User $user, Partidos $partido): bool
    {
        return $user
            ->roles()
            ->where('name', 'admin')
            ->exists();
    }

}
