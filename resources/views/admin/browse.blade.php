@extends('layouts.base')

@section('content')

<div class="container">

    <!-- Success message -->
    @if(Session::has('success'))
    <div class="alert alert-success text-center">
        {{Session::get('success')}}
    </div>
    @endif
    
    <h1 class="text-center">Liste des utilisateurs</h1>
    <h2 class="text-center"><a href=" {{ route('createView') }}">Créer un utilisateur</a></h2>

    <table class="table">
        <thead>
            <tr>
            <th scope="col">Nom</th>
            <th scope="col">Email</th>
            <th scope="col">Crée le</th>
            <th scope="col">Action</th>
            </tr>
        </thead>
        @foreach ($utilisateurs as $utilisateur)
        <tbody>
            <tr>
                <td>{{ $utilisateur->name }}</td>
                <td>{{  $utilisateur->email }}</td>
                <td>{{  $utilisateur->created_at }}</td>

                @if(!$utilisateur->deleted_at)
                    <td><a href="{{ route('edit', [$utilisateur->id]) }}" class="pr-2 text-primary font-weight-bold">Modifier</a><a href="{{ route('delete', [$utilisateur->id]) }}" class="pr-2 text-warning font-weight-bold">Supprimer temporairement</a><a href="{{ route('forceDelete', [$utilisateur->id]) }}" class="text-danger font-weight-bold">Supprimer définitivement</a></td>
                @else
                    <td>Utilisateur supprimé temporairement (gardé en mémoire dans la base)</td>
                @endif
            </tr>
        </tbody>
        @endforeach
    </table>
    
    <small class="text-center d-block"><a href="{{ route('logout') }}">Déconnexion</a></small>
    <small class="text-center d-block"><a href="{{ route('myprofil', [Auth::user()->id] ) }}">Mon profil</a></small>
   
</div>

@endsection