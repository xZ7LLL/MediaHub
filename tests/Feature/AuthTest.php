<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_un_utilisateur_peut_s_inscrire(): void
    {
        $reponse = $this->post('/inscription', [
            'name' => 'Amel',
            'email' => 'amel@exemple.com',
            'password' => 'motdepasse',
            'password_confirmation' => 'motdepasse',
        ]);

        $reponse->assertRedirect(route('accueil'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', ['email' => 'amel@exemple.com', 'role' => 'auteur']);
    }

    public function test_connexion_avec_identifiants_incorrects(): void
    {
        $reponse = $this->post('/connexion', [
            'email' => 'inconnu@exemple.com',
            'password' => 'faux',
        ]);

        $reponse->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_connexion_avec_identifiants_corrects(): void
    {
        $utilisateur = User::factory()->create();

        $reponse = $this->post('/connexion', [
            'email' => $utilisateur->email,
            'password' => 'password',
        ]);

        $reponse->assertRedirect(route('accueil'));
        $this->assertAuthenticatedAs($utilisateur);
    }

    public function test_deconnexion(): void
    {
        $utilisateur = User::factory()->create();

        $reponse = $this->actingAs($utilisateur)->post('/deconnexion');

        $reponse->assertRedirect(route('accueil'));
        $this->assertGuest();
    }
}