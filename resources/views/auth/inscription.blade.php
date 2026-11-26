@extends('layouts.app')
@section('titre', 'Inscription')
@section('contenu')
    <h1>Inscription</h1>
    <form method="POST" action="{{ route('inscription') }}">
        @csrf
        <label for="name">Nom</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}">
        @error('name')
            <span class="erreur-champ">{{ $message }}</span>
        @enderror
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
        <label for="password_confirmation">Confirmer le mot de passe</label>
        <input type="password" name="password_confirmation" id="password_confirmation">
        <button type="submit">S'inscrire</button>
    </form>
@endsection