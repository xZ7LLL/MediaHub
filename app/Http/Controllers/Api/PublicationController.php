<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePublicationRequest;
use App\Http\Requests\UpdatePublicationRequest;
use App\Http\Resources\PublicationResource;
use App\Models\Publication;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PublicationController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $publications = Publication::with('categorie', 'auteur')
            ->latest()
            ->paginate(10);

        return PublicationResource::collection($publications);
    }

    public function show(Publication $publication)
    {
        return new PublicationResource($publication->load('categorie', 'auteur'));
    }

    public function store(StorePublicationRequest $request)
    {
        $publication = Publication::create([
            ...$request->safe()->only(['titre', 'contenu', 'categorie_id']),
            'user_id' => $request->user()->id,
        ]);

        return (new PublicationResource($publication->load('categorie', 'auteur')))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdatePublicationRequest $request, Publication $publication)
    {
        $this->authorize('update', $publication);

        $publication->update($request->safe()->only(['titre', 'contenu', 'categorie_id']));

        return new PublicationResource($publication->load('categorie', 'auteur'));
    }

    public function destroy(Publication $publication)
    {
        $this->authorize('delete', $publication);

        $publication->delete();

        return response()->json(null, 204);
    }
}