@extends('layouts.app')
@section('titre', $publication->titre)
@section('contenu')
    <h1>{{ $publication->titre }}</h1>
    <p>Categorie : {{ $publication->categorie->nom }} | Auteur : {{ $publication->auteur->name }}</p>
    <div>{{ $publication->contenu }}</div>

    <h2>Commentaires ({{ $publication->commentaires->count() }})</h2>
    @forelse ($publication->commentaires as $commentaire)
        <x-carte :titre="$commentaire->auteur->name">
            <p>{{ $commentaire->contenu }}</p>
        </x-carte>
    @empty
        <p>Aucun commentaire pour le moment.</p>
    @endforelse

    <a href="{{ route('contenus.index') }}">Retour à la liste</a>
@endsection