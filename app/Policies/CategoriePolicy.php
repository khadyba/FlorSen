<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Categorie;
use App\Models\Categories;
use Illuminate\Auth\Access\Response;

class CategoriePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function viewAny(Categories $categories): Response
    {
        return $categories->isAdmin()?
        Response::allow():
        Response::deny('Vous n\'êtes pas autorisé à
                                           effectuer cette action!');
      
    }
}
