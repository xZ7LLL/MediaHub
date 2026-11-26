<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Publication;
use Illuminate\Http\Request;

class ContenuController extends Controller
{
    public function index(string $tri = 'recent')
    {
        $publications = Publication::with(['categorie', 'auteur'])
            ->latest()
            ->paginate(9);

        return view('contenus.index', compact('publications'));
    }

    public function create()
    {
        $categories = Categorie::all();

        return view('contenus.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $publication = Publication::create([
            'titre' => $request->input('titre'),
            'contenu' => $request->input('contenu'),
            'categorie_id' => $request->input('categorie_id'),
            'user_id' => 1,
        ]);

        return redirect()
            ->route('contenus.show', $publication)
            ->with('succes', 'Publication créée avec succès.');
    }

    public function show(Publication $publication)
    {
        $publication->load(['categorie', 'auteur', 'commentaires.auteur']);

        return view('contenus.show', ['publication' => $publication]);
    }

    public function edit(Publication $publication)
    {
        $categories = Categorie::all();

        return view('contenus.edit', compact('publication', 'categories'));
    }

    public function update(Request $request, Publication $publication)
    {
        $publication->update($request->only('titre', 'contenu', 'categorie_id'));

        return redirect()
            ->route('contenus.show', $publication)
            ->with('succes', 'Publication mise à jour avec succès.');
    }

    public function destroy(Publication $publication)
    {
        $publication->delete();

        return redirect()
            ->route('contenus.index')
            ->with('succes', 'Publication supprimée avec succès.');
    }
}