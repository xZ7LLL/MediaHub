<?php

namespace Tests\Feature\Api;

use App\Models\Categorie;
use App\Models\Publication;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PublicationApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_liste_des_publications_via_api(): void
    {
        Publication::factory()->count(5)->create();

        $reponse = $this->getJson('/api/publications');

        $reponse->assertStatus(200)->assertJsonCount(5, 'data');
    }

    public function test_creation_sans_jeton_est_refusee(): void
    {
        $reponse = $this->postJson('/api/publications', []);

        $reponse->assertStatus(401);
    }

    public function test_obtention_d_un_jeton(): void
    {
        $utilisateur = User::factory()->create();

        $reponse = $this->postJson('/api/connexion', [
            'email' => $utilisateur->email,
            'password' => 'password',
        ]);

        $reponse->assertOk()->assertJsonStructure(['token']);
    }

    public function test_connexion_api_avec_mauvais_mot_de_passe(): void
    {
        $utilisateur = User::factory()->create();

        $reponse = $this->postJson('/api/connexion', [
            'email' => $utilisateur->email,
            'password' => 'faux',
        ]);

        $reponse->assertStatus(401);
    }

    public function test_creation_avec_jeton(): void
    {
        $utilisateur = User::factory()->create();
        $categorie = Categorie::factory()->create();
        Sanctum::actingAs($utilisateur);

        $reponse = $this->postJson('/api/publications', [
            'titre' => 'Test API',
            'contenu' => 'Contenu de test assez long pour la validation',
            'categorie_id' => $categorie->id,
        ]);

        $reponse->assertCreated()->assertJsonPath('data.titre', 'Test API');
        $this->assertDatabaseHas('publications', ['titre' => 'Test API', 'user_id' => $utilisateur->id]);
    }

    public function test_modification_de_la_publication_d_un_autre_est_interdite(): void
    {
        $publication = Publication::factory()->create();
        Sanctum::actingAs(User::factory()->create());

        $reponse = $this->putJson("/api/publications/{$publication->id}", [
            'titre' => 'Piratage',
            'contenu' => 'Contenu de test assez long pour la validation',
            'categorie_id' => $publication->categorie_id,
        ]);

        $reponse->assertForbidden();
    }
}