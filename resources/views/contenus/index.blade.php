@extends('layouts.app')
@section('titre', 'Contenus')
@section('contenu')
    <h1>Contenus multimédias</h1>
    @forelse ($publications as $publication)
        <x-carte :titre="$publication->titre">
            <p>{{ \Illuminate\Support\Str::limit($publication->contenu, 120) }}</p>
            <p>Catégorie : {{ $publication->categorie->nom }}</p>
            <p>Auteur : {{ $publication->auteur->name }}</p>
            <a href="{{ route('contenus.show', $publication->id) }}">Lire la suite</a>
        </x-carte>
    @empty
        <p>Aucun contenu disponible pour le moment.</p>
    @endforelse
    {{ $publications->links() }}
@endsection