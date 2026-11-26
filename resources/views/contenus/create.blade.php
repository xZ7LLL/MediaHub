@extends('layouts.app')
@section('titre', 'Nouvelle publication')
@section('contenu')
    <h1>Nouvelle publication</h1>
    <form method="POST" action="{{ route('contenus.store') }}">
        @csrf
        <label for="titre">Titre</label>
        <input type="text" name="titre" id="titre" value="{{ old('titre') }}">
        <label for="contenu">Contenu</label>
        <textarea name="contenu" id="contenu" rows="6">{{ old('contenu') }}</textarea>
        <label for="categorie_id">Catégorie</label>
        <select name="categorie_id" id="categorie_id">
            @foreach ($categories as $categorie)
                <option value="{{ $categorie->id }}" @selected(old('categorie_id') == $categorie->id)>
                    {{ $categorie->nom }}
                </option>
            @endforeach
        </select>
        <button type="submit">Créer</button>
    </form>
    <a href="{{ route('contenus.index') }}">Retour</a>
@endsection