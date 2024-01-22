<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticleTest extends TestCase
{
   

    public function test_create_article()
    {
        $user = User::factory()->create([
            'email'=>'admin@example.fr',
            'password'=>bcrypt('password'),
            'role'=>'admin'
        ]);
        $token = JWTAuth::fromUser($user);
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->post('api/createArticle');
        $response->assertStatus(200);
    }

   public function test_lister_article()
   {
    $user = User::factory()->create([
        'email' => 'use@example.com',
        'password'=>bcrypt('passwords'),
    ]);
    $passe =JWTAuth::fromUser($user);
    $response = $this->withHeader('Authorization','Bearer ' . $passe)
                     ->get('api/ListeArticle');
    $response->assertStatus(200);
   }

//    public function test_destroy_article()
//    {
//     $user = User::factory()->create([
//         'email'=>'mail@example.fr',
//         'password'=>bcrypt('password'),
//         'role'=>'admin'
//     ]);
//     $acces= JWTAuth::fromUser($user);
//     $response = $this->withHeader('Authorization','Bearer ' . $acces)
//                       ->delete('api/destroyArticle/{id}');
//     $response->assertStatus(200);
//    }


public function test_create_and_delete_article()
    {
        // Créer un utilisateur admin
        $user = User::factory()->create([
            'email' => 'dmin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Authentifier l'utilisateur et obtenir le token JWT
        $token = Auth::login($user);

        // Créer un nouvel article (simuler l'ajout)
        $articleData = [
            'title' => 'Nouvel article',
            'content' => 'Contenu de l\'article',
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->post("api/createArticle/{$articleData}");

        // Vérifier que la création a réussi
        $response->assertStatus(200);

        // Récupérer l'ID de l'article ajouté
        $article = $response->json('id');

        // Supprimer l'article
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->delete("api/destroyArticle/{$article}");

        // Vérifier que la suppression a réussi
        $response->assertStatus(200);
    }
}
