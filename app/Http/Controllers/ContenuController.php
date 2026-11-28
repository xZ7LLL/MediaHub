<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePublicationRequest;
use App\Http\Requests\UpdatePublicationRequest;
use App\Models\Categorie;
use App\Models\Publication;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;

class ContenuController extends Controller
{
    use AuthorizesRequests;

    public function index(string $tri = 'recent')
    {
        $publications = Publication::with('categorie', 'auteur')
            ->withCount('commentaires')
            ->latest()
            ->paginate(9);

        return view('contenus.index', compact('publications'));
    }

    public function create()
    {
        $categories = Categorie::all();

        return view('contenus.create', compact('categories'));
    }

    public function store(StorePublicationRequest $request)
    {
        $donnees = $request->validated();

        if ($request->hasFile('image')) {
            $donnees['image'] = $request->file('image')->store('publications', 'public');
        }

        if ($request->hasFile('fichier_media')) {
            $fichier = $request->file('fichier_media');
            $donnees['fichier_media'] = $fichier->store('medias', 'public');
            $donnees['type_media'] = str_starts_with($fichier->getMimeType(), 'audio') ? 'audio' : 'video';
        }

        $donnees['user_id'] = auth()->id();

        $publication = Publication::create($donnees);

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
        $this->authorize('update', $publication);

        $categories = Categorie::all();

        return view('contenus.edit', compact('publication', 'categories'));
    }

    public function update(UpdatePublicationRequest $request, Publication $publication)
    {
        $this->authorize('update', $publication);

        $donnees = $request->validated();

        if ($request->hasFile('image')) {
            if ($publication->image) {
                Storage::disk('public')->delete($publication->image);
            }
            $donnees['image'] = $request->file('image')->store('publications', 'public');
        }

        if ($request->hasFile('fichier_media')) {
            if ($publication->fichier_media) {
                Storage::disk('public')->delete($publication->fichier_media);
            }
            $fichier = $request->file('fichier_media');
            $donnees['fichier_media'] = $fichier->store('medias', 'public');
            $donnees['type_media'] = str_starts_with($fichier->getMimeType(), 'audio') ? 'audio' : 'video';
        }

        $publication->update($donnees);

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