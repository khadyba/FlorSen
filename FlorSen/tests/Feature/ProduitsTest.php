<?php

namespace Tests\Feature;

use App\Models\Categories;
use Tests\TestCase;
use App\Models\User;
use App\Models\Produits;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProduitsTest extends TestCase
{
    public function test_create_produits()
    {
        $user = User::factory()->create([
            'email' => 'jardinier@example.com',
            'password' => Hash::make('password'),
            'role' => 'jardinier',
        ]);
        $token = Auth::login($user);
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->post('api/PublierProduits');
        $response->assertStatus(200);
    }
    public function test_update_produits_user_jardinier()
    {
        $jardinier = User::factory()->create([
            'email' => 'jardinie@example.com',
            'password' => Hash::make('password'),
            'role' => 'jardinier',
        ]);
        $token = Auth::login($jardinier);
        $categorie = Categories::factory()->create();
        $produit = Produits::factory()->create([
            'user_id' => $jardinier->id,
            'categories_id' => $categorie->id,
        ]);
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->post('api/ModifierProduits/' . $produit->id);
        $response->assertStatus(200);
    }
    public function test_delete_produits_user_jardinier()
    {
        $jardinier=User::factory()->create([
            'email' => 'jard@example.com',
            'password' => Hash::make('password'),
            'role' => 'jardinier',
        ]);
        $token = Auth::login($jardinier);
        $categorie = Categories::factory()->create();
        $produit = Produits::factory()->create([
            'user_id' => $jardinier->id,
            'categories_id' => $categorie->id,
        ]);
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->delete('api/SupprimerProduits/' . $produit->id);
        $response->assertStatus(200);
    }
    public function test_view_produits_user_jardinier()
    {
        $jardinier = User::factory()->create([
            'email' => 'facteu@example.com',
            'password' => Hash::make('password'),
            'role' => 'jardinier',
        ]);
        $token = Auth::login($jardinier);
        $categorie = Categories::factory()->create();
        $produit = Produits::factory()->create([
            'user_id' => $jardinier->id,
            'categories_id' => $categorie->id,
        ]);
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->get('api/VoirDetailProduits/' . $produit->id);
        $response->assertStatus(200);
    }

    public function test_viewAny_produits_user_jardinier()
    {
        $jardinier = User::factory()->create([
            'email' => 'fa@example.com',
            'password' => Hash::make('password'),
            'role' => 'jardinier',
        ]);
        $token = Auth::login($jardinier);
        $categorie = Categories::factory()->create();
        $produit = Produits::factory()->create([
            'user_id' => $jardinier->id,
            'categories_id' => $categorie->id,
        ]);
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->get('api/ListerProduits' );
        $response->assertStatus(200);
    }

}
