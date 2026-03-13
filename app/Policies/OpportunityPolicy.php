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
        if ($user->isAdmin() || $user->isLead() || $user->isAgentTerrain() || $user->isAgentConseil() || $user->isAgentConseilRenouvellement() ) {
            return true;
        }

        // Agent Conseil Renouvellement ne peut voir que les opportunités gagnées
        if ($user->isAgentConseilRenouvellement()) {
            return $opportunity->status()->exists() && $opportunity->status->slug === 'gagne';
        }

        return $opportunity->created_by === $user->id
            || $opportunity->assigned_to === $user->id;
    }

    public function create(User $user)
    {
        return $user->hasAnyRole(['admin', 'lead', 'agent_terrain','agent_conseil', 'agent_conseil_renouvellement']);
    }

    public function update(User $user, Opportunity $opportunity)
    {
        if ($user->isAdmin() || $user->isLead() || $user->isAgentTerrain() || $user->isAgentConseil() || $user->isAgentConseilRenouvellement() ) {
            return true;
        }

        // Agent Conseil Renouvellement peut mettre à jour les opportunités gagnées
        if ($user->isAgentConseilRenouvellement()) {
            return $opportunity->status()->exists() && $opportunity->status->slug === 'gagne';
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

        // Agent Conseil Renouvellement peut uniquement voir les opportunités gagnées, pas changer leur statut
        if ($user->isAgentConseilRenouvellement()) {
            return false;
        }

        return $opportunity->assigned_to === $user->id;
    }

    public function delete(User $user, Opportunity $opportunity)
    {
        return $user->isAdmin();
    }
}
