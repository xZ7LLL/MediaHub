@extends('layouts.app')
@section('titre', 'Contenus')
@section('contenu')
    <h1>Contenus multimédias</h1>
    <a href="{{ route('contenus.create') }}">Nouvelle publication</a>
    @forelse ($publications as $publication)
        <x-carte :titre="$publication->titre">
            <p>{{ \Illuminate\Support\Str::limit($publication->contenu, 120) }}</p>
            <p>Catégorie : {{ $publication->categorie->nom }}</p>
            <p>Auteur : {{ $publication->auteur->name }}</p>
            <a href="{{ route('contenus.show', $publication) }}">Lire la suite</a>
            <a href="{{ route('contenus.edit', $publication) }}">Modifier</a>
            <form method="POST" action="{{ route('contenus.destroy', $publication) }}">
                @csrf
                @method('DELETE')
                <button type="submit">Supprimer</button>
            </form>
        </x-carte>
    @empty
        <p>Aucun contenu disponible pour le moment.</p>
    @endforelse
    {{ $publications->links() }}
@endsection