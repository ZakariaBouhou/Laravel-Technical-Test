@extends('layouts.base')

@section('content')

    <!-- Success message -->
    @if(Session::has('success'))
        <div class="alert alert-success text-center">
            {{Session::get('success')}}
        </div>
    @endif

    <div class="text-center">
        <h1>Mon profil</h1>    
        <p>Profil de : {{ $user->name }} </p>
        <p>Email : {{ $user->email }} </p>
    </div>

    @auth
        <small class="text-center d-block"><a href="{{ route('logout') }}">Déconnexion</a></small>
        <small class="text-center d-block"><a href="{{ route('edit', $user->id) }}">Modifer mes informations</a></small>
        @endauth
        
        @if (Auth::user()->role === 'ROLE_ADMIN')
        <small class="text-center d-block"><a href="{{ route('forceDelete', $user->id) }}">Supprimer mon compte</a></small>
        <small class="text-center d-block text-primary"><a href="{{ route('browse') }}">Accès au back-office</a></small>
    @endif

@endsection

