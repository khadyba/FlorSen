<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return $user->isAdmin()?
        Response::allow(): Response::deny('Vous n\'êtes pas autorisé à
                                           effectuer cette action!');
      
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): Response
    {
        
        return $user->isAdmin()?
        Response::allow(): Response::deny('Vous n\'êtes pas autorisé à
                                            effectuer cette action!');


    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->role === 'jardinier' || $user->role === 'clients'|| $user->role === 'admi'?
        Response::allow(): Response::deny('Vous n\'êtes pas autorisé à
                                         effectuer cette action!')
        ;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): Response
    {
        return $user->role === 'jardinier' || $user->role === 'clients'|| $user->role === 'admi'?
        Response::allow(): Response::deny('Vous n\'êtes pas autorisé à
                                              effectuer cette action!')
        ;
      
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function blockUser(User $user ): Response
    {
        return $user->isAdmin()?
        Response::allow(): Response::deny('Vous n\'êtes pas autorisé à effectuer cette action!')
        ;
    }


    public function debloquerUser(User $user ): Response
    {
        return $user->isAdmin()?Response::allow():Response::deny('Vous n\'êtes pas autorisé à effectuer cette action!');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user): bool
    {
        return $user->role === 'admin';
    }
}
