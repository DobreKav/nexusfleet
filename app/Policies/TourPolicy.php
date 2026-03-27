<?php

namespace App\Policies;

use App\Models\Tour;
use App\Models\User;

class TourPolicy
{
    public function view(User $user, Tour $tour): bool
    {
        // Ако не е истаа компанија, забрани
        if ($user->company_id !== $tour->company_id) {
            return false;
        }
        
        // Ако е возач, само неговите тури
        if ($user->isDriver()) {
            $driver = $user->driver;
            return $driver && $driver->id === $tour->driver_id;
        }
        
        // За админи и други - дозволено
        return true;
    }

    public function update(User $user, Tour $tour): bool
    {
        // Ако не е истаа компанија, забрани
        if ($user->company_id !== $tour->company_id) {
            return false;
        }
        
        // Возачите не смеат да изменуваат тури
        if ($user->isDriver()) {
            return false;
        }
        
        // За админи и други - дозволено
        return true;
    }

    public function delete(User $user, Tour $tour): bool
    {
        // Ако не е истаа компанија, забрани
        if ($user->company_id !== $tour->company_id) {
            return false;
        }
        
        // Возачите не смеат да бришат тури
        if ($user->isDriver()) {
            return false;
        }
        
        // За админи и други - дозволено
        return true;
    }
}
