@extends('layouts.app')
@section('titre', 'Modifier la catégorie')
@section('contenu')
    <h1>Modifier la catégorie</h1>
    <form method="PUT" action="{{ route('categories.update') }}">
    @csrf
    <label for="nom">Nom</label>
    <input type="text" name="nom" id="nom" value="{{ old('nom', $categorie->nom) }}">
    @error('nom')
        <span class="erreur-champ">{{ $message }}</span>
    @enderror
    <label for="slug">Slug</label>
    <input type="text" name="slug" id="slug" value="{{ old('slug', $categorie->slug) }}">
    @error('slug')
        <span class="erreur-champ">{{ $message }}</span>
    @enderror
    <button type="submit">Créer</button>
    </form>
    <a href="{{ route('categories.index') }}">Retour</a>
@endsection
