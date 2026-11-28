<?php

namespace Tests\Feature;

use App\Models\Commentaire;
use App\Models\Publication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ContenuListTest extends TestCase
{
    use RefreshDatabase;

    public function test_la_liste_n_execute_pas_une_requete_par_publication(): void
    {
        $publications = Publication::factory()->count(9)->create();

        foreach ($publications as $publication) {
            Commentaire::create([
                'contenu' => 'Un commentaire',
                'publication_id' => $publication->id,
                'user_id' => $publication->user_id,
            ]);
        }

        DB::flushQueryLog();
        DB::enableQueryLog();

        $reponse = $this->get('/contenus');

        $reponse->assertOk()->assertSee('1 commentaire(s)');
        $this->assertLessThanOrEqual(6, count(DB::getQueryLog()));
    }
}