@extends('layouts.base')

@section('content')

<div class="container">

    <!-- Success message -->
    @if(Session::has('success'))
    <div class="alert alert-success text-center">
        {{Session::get('success')}}
    </div>
    @endif

    <form action="" method="post" action="{{ action('App\Http\Controllers\UserController@connexion') }}" class="d-flex flex-column align-items-center">

        @csrf

        <div class="form-group w-25">
            <label>Email</label>
            <input type="text" class="form-control {{ $errors->has('email') ? 'error' : '' }}" name="email"
                id="email">

            @if ($errors->has('email'))
            <div class="error text-danger">
                {{ $errors->first('email') }}
            </div>
            @endif
        </div>

        <div class="form-group w-25">
            <label>Mot de passe</label>
            <input type="password" class="form-control {{ $errors->has('password') ? 'error' : '' }}" name="password"
                id="password">

            @if ($errors->has('password'))
            <div class="error text-danger">
                {{ $errors->first('password') }}
            </div>
            @endif
        </div>

        <input type="submit" name="send" value="Connexion" class="btn btn-dark btn-block w-25 mt-2">
    </form>

    @guest
        <small class="text-center d-block">Pas encore inscrit ? C'est <a href="{{ route('register') }}">par ici</a></small>
    @endguest
    @auth
        <small class="text-center d-block"><a href="{{ route('logout') }}">Déconnexion</a></small>
    @endauth
</div>

@endsection
