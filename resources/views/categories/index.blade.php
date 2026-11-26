@extends('layouts.app')
@section('titre', 'Catégories')
@section('contenu')
    <h1>Catégories</h1>
    <a href="{{ route('categories.create') }}">Nouvelle catégorie</a>
    @forelse ($categories as $categorie)
        <x-carte :titre="$categorie->nom">
            <p>Slug : {{ $categorie->slug }}</p>
            <p>{{ $categorie->publications_count }} publication(s)</p>
            <a href="{{ route('categories.edit', $categorie) }}">Modifier</a>
            <form method="POST" action="{{ route('categories.destroy', $categorie) }}">
                @csrf
                @method('DELETE')
                <button type="submit">Supprimer</button>
            </form>
        </x-carte>
    @empty
        <p>Aucune catégorie pour le moment.</p>
    @endforelse
@endsection