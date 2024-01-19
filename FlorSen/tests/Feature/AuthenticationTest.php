<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
}

