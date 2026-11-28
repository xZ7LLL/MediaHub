<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PublicationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'titre' => $this->titre,
            'contenu' => $this->contenu,
            'categorie' => $this->categorie->nom,
            'auteur' => $this->auteur->name,
            'image' => $this->image ? Storage::url($this->image) : null,
            'publie_le' => $this->created_at->toDateString(),
        ];
    }
}