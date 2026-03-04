<?php

namespace App\Policies;

use App\Models\InsurancePartner;
use App\Models\User;

class InsurancePartnerPolicy
{
    /**
     * Determine whether the user can view any insurance partners.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the insurance partner.
     */
    public function view(User $user, InsurancePartner $insurancePartner): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can create insurance partners.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the insurance partner.
     */
    public function update(User $user, InsurancePartner $insurancePartner): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the insurance partner.
     */
    public function delete(User $user, InsurancePartner $insurancePartner): bool
    {
        return $user->isAdmin();
    }
}
