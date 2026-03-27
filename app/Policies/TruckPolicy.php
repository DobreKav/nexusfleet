<?php

namespace App\Policies;

use App\Models\Truck;
use App\Models\User;

class TruckPolicy
{
    public function view(User $user, Truck $truck): bool
    {
        return $user->company_id === $truck->company_id;
    }

    public function update(User $user, Truck $truck): bool
    {
        return $user->company_id === $truck->company_id;
    }

    public function delete(User $user, Truck $truck): bool
    {
        return $user->company_id === $truck->company_id;
    }
}
