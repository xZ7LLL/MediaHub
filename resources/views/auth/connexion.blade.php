@extends('layouts.app')
@section('titre', 'Connexion')
@section('contenu')
    <h1>Connexion</h1>
    <form method="POST" action="{{ route('connexion') }}">
        @csrf
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}">
        @error('email')
            <span class="erreur-champ">{{ $message }}</span>
        @enderror
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password">
        @error('password')
            <span class="erreur-champ">{{ $message }}</span>
        @enderror
        <button type="submit">Se connecter</button>
    </form>
@endsection