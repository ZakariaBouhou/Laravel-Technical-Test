@extends('layouts.base')

@section('content')

<div class="container">

    <!-- Success message -->
    @if(Session::has('success'))
    <div class="alert alert-success">
        {{Session::get('success')}}
    </div>
    @endif

    <form method="post" action="{{ route('update', $utilisateur->id) }}">

        @csrf

        <div class="form-group w-25 m-auto">
            <label>Nom</label>
            <input type="text" class="form-control {{ $errors->has('name') ? 'error' : '' }}" name="name" value="{{ $utilisateur->name }}" id="name">

            <!-- Error -->
            @if ($errors->has('name'))
            <div class="error">
                {{ $errors->first('name') }}
            </div>
            @endif
        </div>

        <div class="form-group w-25 m-auto">
            <label>Email</label>
            <input type="text" class="form-control {{ $errors->has('email') ? 'error' : '' }}" name="email" value="{{ $utilisateur->email }}"
                id="email">

            @if ($errors->has('email'))
            <div class="error">
                {{ $errors->first('email') }}
            </div>
            @endif
        </div>

        <div class="form-group w-25 m-auto">
            <label>Mot de passe</label>
            <input type="password" class="form-control {{ $errors->has('password') ? 'error' : '' }}" name="password"
            id="password">

            @if ($errors->has('password'))
            <div class="error">
                {{ $errors->first('password') }}
            </div>
            @endif
        </div>
        <input type="submit" name="send" value="Modifier mes informations" class="btn btn-dark btn-block w-25 m-auto">
    </form>
    <small class="text-center d-block"><a href="{{ route('myprofil', $utilisateur->id) }}">Retour sur mon profil</a></small>
    <small class="text-center d-block"><a href="{{ route('logout') }}">Déconnexion</a></small>
</div>

@endsection