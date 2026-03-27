<?php

namespace App\Policies;

use App\Models\Trailer;
use App\Models\User;

class TrailerPolicy
{
    public function view(User $user, Trailer $trailer): bool
    {
        return $user->company_id === $trailer->company_id;
    }

    public function update(User $user, Trailer $trailer): bool
    {
        return $user->company_id === $trailer->company_id;
    }

    public function delete(User $user, Trailer $trailer): bool
    {
        return $user->company_id === $trailer->company_id;
    }
}
