@extends('layouts.app')
@section('titre', 'Contenus')
@section('contenu')
    <h1>Contenus multimédias</h1>
    @auth
        <a href="{{ route('contenus.create') }}">Nouvelle publication</a>
    @endauth
    @forelse ($publications as $publication)
        <x-carte :titre="$publication->titre">
            @if ($publication->image)
                <img src="{{ Storage::url($publication->image) }}" alt="{{ $publication->titre }}" width="200">
            @endif
            <p>{{ \Illuminate\Support\Str::limit($publication->contenu, 120) }}</p>
            <p>Catégorie : {{ $publication->categorie->nom }}</p>
            <p>Auteur : {{ $publication->auteur->name }}</p>
            <p>{{ $publication->commentaires_count }} commentaire(s)</p>
            <a href="{{ route('contenus.show', $publication) }}">Lire la suite</a>
            @can('update', $publication)
                <a href="{{ route('contenus.edit', $publication) }}">Modifier</a>
            @endcan
            @can('delete', $publication)
                <form method="POST" action="{{ route('contenus.destroy', $publication) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Supprimer</button>
                </form>
            @endcan
        </x-carte>
    @empty
        <p>Aucun contenu disponible pour le moment.</p>
    @endforelse
    {{ $publications->links() }}
@endsection