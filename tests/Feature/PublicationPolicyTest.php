<?php

namespace Tests\Feature;

use App\Models\Publication;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicationPolicyTest extends TestCase
{
    use RefreshDatabase;

    private function donnees(Publication $publication): array
    {
        return [
            'titre' => 'Titre modifié',
            'contenu' => str_repeat('a', 30),
            'categorie_id' => $publication->categorie_id,
        ];
    }

    public function test_un_visiteur_est_redirige_vers_la_connexion(): void
    {
        $this->get('/contenus/create')->assertRedirect(route('connexion'));
    }

    public function test_un_auteur_peut_modifier_sa_propre_publication(): void
    {
        $auteur = User::factory()->create();
        $publication = Publication::factory()->create(['user_id' => $auteur->id]);

        $reponse = $this->actingAs($auteur)
            ->put("/contenus/{$publication->id}", $this->donnees($publication));

        $reponse->assertRedirect("/contenus/{$publication->id}");
        $this->assertDatabaseHas('publications', ['id' => $publication->id, 'titre' => 'Titre modifié']);
    }

    public function test_un_auteur_ne_peut_pas_modifier_la_publication_d_un_autre(): void
    {
        $publication = Publication::factory()->create();
        $intrus = User::factory()->create();

        $reponse = $this->actingAs($intrus)
            ->put("/contenus/{$publication->id}", $this->donnees($publication));

        $reponse->assertForbidden();
        $this->assertDatabaseMissing('publications', ['titre' => 'Titre modifié']);
    }

    public function test_un_admin_peut_modifier_n_importe_quelle_publication(): void
    {
        $publication = Publication::factory()->create();
        $admin = User::factory()->create(['role' => 'admin']);

        $reponse = $this->actingAs($admin)
            ->put("/contenus/{$publication->id}", $this->donnees($publication));

        $reponse->assertRedirect("/contenus/{$publication->id}");
    }
}