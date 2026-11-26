@extends('layouts.app')
@section('titre', 'Nouvelle publication')
@section('contenu')
    <h1>Nouvelle publication</h1>
    <form method="POST" action="{{ route('contenus.store') }}" enctype="multipart/form-data">
        @csrf
        <label for="titre">Titre</label>
        <input type="text" name="titre" id="titre" value="{{ old('titre') }}">
        @error('titre')
            <span class="erreur-champ">{{ $message }}</span>
        @enderror

        <label for="contenu">Contenu</label>
        <textarea name="contenu" id="contenu" rows="6">{{ old('contenu') }}</textarea>
        @error('contenu')
            <span class="erreur-champ">{{ $message }}</span>
        @enderror

        <label for="categorie_id">Catégorie</label>
        <select name="categorie_id" id="categorie_id">
            @foreach ($categories as $categorie)
                <option value="{{ $categorie->id }}" @selected(old('categorie_id') == $categorie->id)>
                    {{ $categorie->nom }}
                </option>
            @endforeach
        </select>
        @error('categorie_id')
            <span class="erreur-champ">{{ $message }}</span>
        @enderror

        <label for="image">Image</label>
        <input type="file" name="image" id="image" accept="image/*">
        @error('image')
            <span class="erreur-champ">{{ $message }}</span>
        @enderror

        <label for="fichier_media">Fichier audio ou vidéo</label>
        <input type="file" name="fichier_media" id="fichier_media" accept="audio/*,video/*">
        @error('fichier_media')
            <span class="erreur-champ">{{ $message }}</span>
        @enderror

        <button type="submit">Publier</button>
    </form>
    <a href="{{ route('contenus.index') }}">Retour</a>
@endsection