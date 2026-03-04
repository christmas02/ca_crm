<?php

namespace App\Policies;

use App\Models\Contract;
use App\Models\User;

class ContractPolicy
{
    /**
     * Determine whether the user can view any contracts.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isLead() || $user->isAgentConseil();
    }

    /**
     * Determine whether the user can view the contract.
     */
    public function view(User $user, Contract $contract): bool
    {
        return $user->isAdmin() 
            || $user->isLead() 
            || ($user->isAgentConseil() && $contract->opportunity->assigned_to === $user->id);
    }

    /**
     * Determine whether the user can create contracts.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isLead() || $user->isAgentConseil();
    }

    /**
     * Determine whether the user can update the contract.
     */
    public function update(User $user, Contract $contract): bool
    {
        return $user->isAdmin() 
            || $user->isLead() 
            || ($user->isAgentConseil() && $contract->opportunity->assigned_to === $user->id);
    }

    /**
     * Determine whether the user can delete the contract.
     */
    public function delete(User $user, Contract $contract): bool
    {
        return $user->isAdmin() || $user->isLead();
    }
}
