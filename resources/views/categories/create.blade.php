@extends('layouts.app')
@section('titre', 'Nouvelle catégorie')
@section('contenu')
    <h1>Nouvelle catégorie</h1>
    <form method="POST" action="{{ route('categories.store') }}">
    @csrf
    <label for="nom">Nom</label>
    <input type="text" name="nom" id="nom" value="{{ old('nom') }}">
    @error('nom')
        <span class="erreur-champ">{{ $message }}</span>
    @enderror
    <label for="slug">Slug</label>
    <input type="text" name="slug" id="slug" value="{{ old('slug') }}">
    @error('slug')
        <span class="erreur-champ">{{ $message }}</span>
    @enderror
    <button type="submit">Créer</button>
</form>
    <a href="{{ route('categories.index') }}">Retour</a>
@endsection
