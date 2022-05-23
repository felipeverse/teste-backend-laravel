<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Notification;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Laravel\Sanctum\Sanctum;


class LoginTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Notification::fake();

        User::factory()->create([
            'email' => 'johndoe@example.org',
            'password' => Hash::make('testpassword')
        ]);
    }

    public function test_usuario_pode_logar_com_email_e_senha()
    {
        $response = $this->postJson(route('login'), [
            'email' => 'johndoe@example.org',
            'password' => 'testpassword'
        ])
            ->assertOk();

        $this->assertArrayHasKey('access_token', $response->json());   
        
    }

    public function test_mostra_erro_de_validacao_com_campos_vazios()
    {
        $response = $this->json('POST', route('login'), [
            'email' => '',
            'password' => ''
        ]);

        $response->assertStatus(422);
    }

    public function test_mostrar_erro_quando_tenta_login_com_dados_incorretos()
    {
        $response = $this->json('POST', route('login'), [
            'email' => 'test@test.com',
            'password' => 'abcdabcd'
        ]);

        $response->assertStatus(401)
            ->assertExactJson(['message' => 'Unauthorized']);        
    }

    public function test_usuario_autenticado_pode_obter_dados_do_usuario()
    {
        Sanctum::actingAs(
            User::first(),
        );

        $response = $this->json('GET', route('profile'));

        $response->assertStatus(200)
            ->assertJsonStructure(['name', 'email']);
    } 

    public function test_usuario_autenticado_pode_deslogar()
    {
        Sanctum::actingAs(
            User::first(),
        );

        $response = $this->json('POST', route('logout'), []);

        $response->assertStatus(200);
    }

}
