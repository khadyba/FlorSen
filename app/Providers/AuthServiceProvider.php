<?php

namespace App\Providers;
use App\Models\User;
use App\Models\Article;
use App\Models\Categories;
use App\Models\Produits;
use App\Policies\UserPolicy;
use App\Policies\ArticlePolicy;
use App\Policies\CategoriePolicy;
use App\Policies\ProduitsPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Article::class => ArticlePolicy::class,
        Produits::class => ProduitsPolicy::class,
        Categories::class => CategoriePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
