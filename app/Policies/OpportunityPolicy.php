<?php

namespace App\Policies;

use App\Models\Opportunity;
use App\Models\User;

class OpportunityPolicy
{
    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Opportunity $opportunity)
    {
        if ($user->isAdmin() || $user->isLead()) {
            return true;
        }

        return $opportunity->created_by === $user->id
            || $opportunity->assigned_to === $user->id;
    }

    public function create(User $user)
    {
        return $user->hasAnyRole(['admin', 'lead', 'agent_terrain']);
    }

    public function update(User $user, Opportunity $opportunity)
    {
        if ($user->isAdmin() || $user->isLead()) {
            return true;
        }

        return $opportunity->assigned_to === $user->id;
    }

    public function assign(User $user, Opportunity $opportunity)
    {
        return $user->isAdmin() || $user->isLead();
    }

    public function changeStatus(User $user, Opportunity $opportunity)
    {
        if ($user->isAdmin() || $user->isLead()) {
            return true;
        }

        return $opportunity->assigned_to === $user->id;
    }

    public function delete(User $user, Opportunity $opportunity)
    {
        return $user->isAdmin();
    }
}
