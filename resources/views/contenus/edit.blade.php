@extends('layouts.app')
@section('titre', 'Modifier la publication')
@section('contenu')
    <h1>Modifier la publication</h1>
    <form method="POST" action="{{ route('contenus.update', $publication) }}">
        @csrf
        @method('PUT')
        <label for="titre">Titre</label>
        <input type="text" name="titre" id="titre" value="{{ old('titre', $publication->titre) }}">
        <label for="contenu">Contenu</label>
        <textarea name="contenu" id="contenu" rows="6">{{ old('contenu', $publication->contenu) }}</textarea>
        <label for="categorie_id">Catégorie</label>
        <select name="categorie_id" id="categorie_id">
            @foreach ($categories as $categorie)
                <option value="{{ $categorie->id }}" @selected(old('categorie_id', $publication->categorie_id) == $categorie->id)>
                    {{ $categorie->nom }}
                </option>
            @endforeach
        </select>
        <button type="submit">Enregistrer</button>
    </form>
    <a href="{{ route('contenus.show', $publication) }}">Retour</a>
@endsection