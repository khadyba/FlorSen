<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Article;
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
/**
 * Test the creation and deletion of an article.
 */
public function test_delete_article()
{
    $user = User::factory()->create([
        'email' =>'amin@example.com',
        'password' => Hash::make('password'),
        'role' => 'admin',
    ]);
    $token = Auth::login($user);
    $article = Article::factory()->create();
    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->delete('api/destroyArticle/' . $article->id);
    $response->assertStatus(200);
}
public function test_update_article()
{
    $user = User::factory()->create([
        'email' => 'amin@example.com',
        'password' => Hash::make('password'),
        'role' => 'admin',
    ]);
    $token = Auth::login($user);
    $article = Article::factory()->create();
    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->post("api/updateArticle/{$article->id}", [
            'titre' => 'updated title',
            'image' => 'updated image',
            'contenue' => 'updated content',
        ]);

    $response->assertStatus(200);
}
public function test_view_article()
{
    $user = User::factory()->create([
        'email' => 'amin@example.com',
        'password' => Hash::make('password'),
        'role' => 'admin',
    ]);
    $token = Auth::login($user);
    $article = Article::factory()->create();
    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->get("api/VoirDetailArticle/{$article->id}");
    $response->assertStatus(200);
}
}


