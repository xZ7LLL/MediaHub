@extends('layouts.app')
@section('titre', 'Modifier la catégorie')
@section('contenu')
    <h1>Modifier la catégorie</h1>
    <form method="POST" action="{{ route('categories.update', $categorie) }}">
        @csrf
        @method('PUT')
        <label for="nom">Nom</label>
        <input type="text" name="nom" id="nom" value="{{ old('nom', $categorie->nom) }}">
        <label for="slug">Slug</label>
        <input type="text" name="slug" id="slug" value="{{ old('slug', $categorie->slug) }}">
        <button type="submit">Enregistrer</button>
    </form>
    <a href="{{ route('categories.index') }}">Retour</a>
@endsection
