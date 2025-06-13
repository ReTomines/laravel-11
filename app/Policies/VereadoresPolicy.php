<?php

namespace App\Policies;

use App\Models\{User, Vereadores};

class VereadoresPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function edit(User $user, Vereadores $vereador)
    {
        return $user
            ->roles()
            ->where('name', 'admin')
            ->exists();
    }

    public function destroy(User $user, Vereadores $vereador): bool
    {
        return $user
            ->roles()
            ->where('name', 'admin')
            ->exists();
    }
}
