<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
class AuthenticationTest extends TestCase
{

    public function test_user_can_register()
    {
        
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/api/register');
        $response->assertStatus(200);
       
    }

    public function test_user_can_login()
    {
        $user= User::factory()->create();
        $credential= ['email'=>$user->email,'password'=>'password'];
        $response = $this->post('/api/login',$credential);
        $response->assertStatus(200)
        ->assertSuccessful([
            'email' => 'une adresse  email doit etre fournie',
            'password' => 'Le mot de passe est requis et doit avoir au minimum 7 caractères',
        ]);
    }
    public function    test_user_can_logout()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);
        $token = JWTAuth::fromUser($user);
        $response = $this->withHeader('Authorization', 'Bearer' . $token)
                         ->post('/api/logout');
        $response->assertStatus(200);
    }
     public function test_user_can_viewAni()
     {
        $user = User::factory()->create([
            'email'=>'admin@example.com',
            'password'=>bcrypt('password')
        ]);
        $token = JWTAuth::fromUser($user);
        
        $response = $this->withHeader('Authorization', 'Bearer' . $token)
                         ->get('api/listJardinier');
        $response->assertStatus(200);
     }
   
       public function test_user_can_vienAny()
       {
        $user = User::factory()->create([
            'email'=>'admin@example.fr',
            'password'=>bcrypt('password')
        ]);
        $token = JWTAuth::fromUser($user);
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->get('api/listClients');
        $response->assertStatus(200);
       }
     

       public function test_user_can_update()
       {
        $user = User::factory()->create([
            'email'=>'khady@example.fr',
            'password'=>bcrypt('password')
        ]);
        $token = JWTAuth::fromUser($user);
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->post('api/modifierProfil/{id}');
        $response->assertStatus(403);
       }
}

