<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Article;
use Illuminate\Auth\Access\Response;

class ArticlePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Article $article): bool
    {
        
       return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->isAdmin()?
        Response::allow():Response::deny('Vous n\'êtes pas autorisé à effectuer cette action!');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Article $article): Response
    {
        return $user->isAdmin()?
        Response::allow(): Response::deny('Vous n\'êtes pas autorisé à effectuer cette action!');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Article $article): Response
    {
        return $user->isAdmin()?
        Response::allow(): Response::deny('Vous n\'êtes pas autorisé à effectuer cette action!');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Article $article): Response
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Article $article): Response
    {
        return $user->isAdmin()?
        Response::allow(): Response::deny('Vous n\'êtes pas autorisé à effectuer cette action!');
    }
}
