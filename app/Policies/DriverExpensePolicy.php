<?php

namespace App\Policies;

use App\Models\DriverExpense;
use App\Models\User;

class DriverExpensePolicy
{
    public function view(User $user, DriverExpense $expense): bool
    {
        return $user->company_id === $expense->driver->company_id;
    }

    public function update(User $user, DriverExpense $expense): bool
    {
        return $user->company_id === $expense->driver->company_id;
    }

    public function delete(User $user, DriverExpense $expense): bool
    {
        return $user->company_id === $expense->driver->company_id;
    }
}
