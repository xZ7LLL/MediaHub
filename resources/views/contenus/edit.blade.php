@extends('layouts.app')
@section('titre', 'Modifier la publication')
@section('contenu')
    <h1>Modifier la publication</h1>
    <form method="POST" action="{{ route('contenus.update', $publication) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <label for="titre">Titre</label>
        <input type="text" name="titre" id="titre" value="{{ old('titre', $publication->titre) }}">
        @error('titre')
            <span class="erreur-champ">{{ $message }}</span>
        @enderror

        <label for="contenu">Contenu</label>
        <textarea name="contenu" id="contenu" rows="6">{{ old('contenu', $publication->contenu) }}</textarea>
        @error('contenu')
            <span class="erreur-champ">{{ $message }}</span>
        @enderror

        <label for="categorie_id">Catégorie</label>
        <select name="categorie_id" id="categorie_id">
            @foreach ($categories as $categorie)
                <option value="{{ $categorie->id }}" @selected(old('categorie_id', $publication->categorie_id) == $categorie->id)>
                    {{ $categorie->nom }}
                </option>
            @endforeach
        </select>
        @error('categorie_id')
            <span class="erreur-champ">{{ $message }}</span>
        @enderror

        @if ($publication->image)
            <img src="{{ Storage::url($publication->image) }}" alt="{{ $publication->titre }}" width="150">
        @endif
        <label for="image">Remplacer l'image</label>
        <input type="file" name="image" id="image" accept="image/*">
        @error('image')
            <span class="erreur-champ">{{ $message }}</span>
        @enderror

        @if ($publication->fichier_media)
            <p>Fichier actuel : {{ basename($publication->fichier_media) }}</p>
        @endif
        <label for="fichier_media">Remplacer le fichier audio ou vidéo</label>
        <input type="file" name="fichier_media" id="fichier_media" accept="audio/*,video/*">
        @error('fichier_media')
            <span class="erreur-champ">{{ $message }}</span>
        @enderror

        <button type="submit">Enregistrer</button>
    </form>
    <a href="{{ route('contenus.show', $publication) }}">Retour</a>
@endsection