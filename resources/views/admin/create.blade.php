@extends('layouts.base')

@section('content')

<div class="container">

    <!-- Success message -->
    @if(Session::has('success'))
    <div class="alert alert-success">
        {{Session::get('success')}}
    </div>
    @endif

    <form method="post" action="{{ route('createView') }}" class="d-flex flex-column align-items-center">

        @csrf

        <div class="form-group w-25">
            <label>Nom</label>
            <input type="text" class="form-control {{ $errors->has('name') ? 'error' : '' }}" name="name" id="name">

            <!-- Error -->
            @if ($errors->has('name'))
            <div class="error">
                {{ $errors->first('name') }}
            </div>
            @endif
        </div>

        <div class="form-group w-25">
            <label>Email</label>
            <input type="text" class="form-control {{ $errors->has('email') ? 'error' : '' }}" name="email"
                id="email">

            @if ($errors->has('email')) 
            <div class="error">
                {{ $errors->first('email') }}
            </div>
            @endif
        </div>

        <div class="form-group w-25">
            <label>Mot de passe</label>
            <input type="password" class="form-control {{ $errors->has('password') ? 'error' : '' }}" name="password"
                id="password">

            @if ($errors->has('password'))
            <div class="error">
                {{ $errors->first('password') }}
            </div>
            @endif
        </div>

        <div class="form-group w-25">
            <label>Confirmer mot de passe</label>
            <input type="password" class="form-control {{ $errors->has('password') ? 'error' : '' }}" name="password_confirmation"
                id="password">

            @if ($errors->has('password'))
            <div class="error">
                {{ $errors->first('password') }}
            </div>
            @endif
        </div>
        <input type="submit" name="send" value="Ajouter" class="btn btn-dark btn-block w-25">
    </form>
    <small class="text-center d-block"><a href="{{ route('browse') }}">Retour au tableau de bord</a></small>
</div>

@endsection
