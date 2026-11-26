<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Publication;
use Illuminate\Http\Request;
use App\Http\Requests\StorePublicationRequest;
use App\Http\Requests\UpdatePublicationRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ContenuController extends Controller
{
    use AuthorizesRequests;
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

    

    public function show(Publication $publication)
    {
        $publication->load(['categorie', 'auteur', 'commentaires.auteur']);

        return view('contenus.show', ['publication' => $publication]);
    }

    public function edit(Publication $publication)
    {
    $this->authorize('update', $publication);

    $categories = Categorie::all();

    return view('contenus.edit', compact('publication', 'categories'));
    }

    public function store(StorePublicationRequest $request)
    {
        $publication = Publication::create([
            ...$request->validated(),
            'user_id' => auth()->id(),
    ]);

    return redirect()
        ->route('contenus.show', $publication)
        ->with('succes', 'Publication créée avec succès.');
    }

public function update(UpdatePublicationRequest $request, Publication $publication)
    {
    $this->authorize('update', $publication);

    $publication->update($request->validated());

    return redirect()
        ->route('contenus.show', $publication)
        ->with('succes', 'Publication mise à jour avec succès.');
    }

public function destroy(Publication $publication)
    {
    $this->authorize('delete', $publication);

    $publication->delete();

    return redirect()
        ->route('contenus.index')
        ->with('succes', 'Publication supprimée avec succès.');
    }
}