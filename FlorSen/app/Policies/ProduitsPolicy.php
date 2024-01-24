<?php

namespace App\Policies;

use App\Models\Produits;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProduitsPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(): bool
    {
        return  true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->isJardinier()?
        Response::allow():
        Response::deny('Vous n\'êtes pas autorisé à effectuer cette action!');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): Response
    {
        return $user->isJardinier()?
        Response::allow():
        Response::deny('Vous n\'êtes pas autorisé à effectuer cette action!');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): Response
    {
        return $user->isJardinier()?
        Response::allow():
        Response::deny('Vous n\'êtes pas autorisé à  effectuer cette action!');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function retirer(User $user): Response
    {
        return $user->isJardinier()?
        Response::allow():
        Response::deny('Vous n\'êtes pas autorisé à
                         effectuer cette action!');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user): Response
    {
        return $user->isJardinier()?
        Response::allow():
        Response::deny('Vous n\'êtes pas autorisé à
                         effectuer cette action!');
    }
}
