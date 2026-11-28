<?php

namespace Tests\Feature;

use App\Models\Categorie;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class CategorieTest extends TestCase
{
    use RefreshDatabase;

    public function test_creation_d_une_categorie_par_un_admin(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $reponse = $this->actingAs($admin)->post('/categories', [
            'nom' => 'Podcast',
            'slug' => 'podcast',
        ]);

        $reponse->assertRedirect('/categories');
        $this->assertDatabaseHas('categories', ['slug' => 'podcast']);
    }

    public function test_un_slug_deja_utilise_est_refuse(): void
    {
        Categorie::factory()->create(['slug' => 'video']);

        $reponse = $this->post('/categories', [
            'nom' => 'Autre',
            'slug' => 'video',
        ]);

        $reponse->assertSessionHasErrors('slug');
        $this->assertDatabaseCount('categories', 1);
    }

    public function test_modification_en_gardant_son_propre_slug(): void
    {
        $categorie = Categorie::factory()->create(['slug' => 'audio']);

        $reponse = $this->put("/categories/{$categorie->id}", [
            'nom' => 'Audio modifié',
            'slug' => 'audio',
        ]);

        $reponse->assertRedirect('/categories');
        $this->assertDatabaseHas('categories', ['id' => $categorie->id, 'nom' => 'Audio modifié']);
    }

    public function test_le_cache_est_invalide_apres_une_creation(): void
    {
        $this->get('/categories')->assertOk();
        $this->assertTrue(Cache::has('categories.liste'));

        $this->post('/categories', [
            'nom' => 'Podcast',
            'slug' => 'podcast',
        ]);

        $this->assertFalse(Cache::has('categories.liste'));
    }
}