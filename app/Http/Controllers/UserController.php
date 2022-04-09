<?php

namespace App\Http\Controllers;

use App\Models\Utilisateurs;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller

{   
    public function register () {

        return view('create');

    }

    // Traitement des données du formulaire
    public function create (Request $request) {

        //dd($request);

        $password = hash::make($request->password);

        $this->validate($request, [

            'name' => 'required',
            'email' => ['required', 'email', 'unique:Utilisateurs'],
            'password' => ['required', 'confirmed', Password::min(8)],

        ]);

        Utilisateurs::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $password
        ]);

        return redirect()->route('login')->with('success', 'Vous êtes bien inscrit ! Vous pouvez maintenant vous connecter');
        
    }

    public function edit ($id) {

        $utilisateur = Utilisateurs::findOrFail($id);   
        //dd($utilisateur->password);

        return view('edit', [
            'utilisateur' => $utilisateur,
        ]);
        
    }

    public function update (Request $request, $id) {

        //dd($request->password);
        
        $this->validate($request, [
            
            'name' => ['min:3', 'max:255'],
            'email' => 'email',
            'password' => Password::min(8),
        ]);
        
        $utilisateur = Utilisateurs::find($id);

        $utilisateur->name = $request->input('name');
        $utilisateur->email = $request->input('email');
        $utilisateur->password = Hash::make($request->input('password'));

        $utilisateur->update();

        //dd($utilisateur->password);

        return redirect()->route('myprofil', ['id' => $request->id])->with('success', 'Informations modifiées !');
        
    }

    public function delete ($id) {

        $utilisateur = Utilisateurs::findOrFail($id);
        $utilisateur->delete();

        return redirect()->route('login')->with('success', 'Compte supprimé');

    }

    public function login () {

        return view('login');
        
    }
    
    public function connexion (Request $request) {
      
        $usersInformations = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Si l'authentification fonctionne, on connecte l'utilisateur
        if (Auth::attempt($usersInformations)) {

            $user = Utilisateurs::where('email', $request->email)->first();
            
            return redirect()->route('myprofil', ['id' => $user->id])->with('success', 'Vous êtes bien connecté');
            
        }
        
        else {
            
            // Sinon on retourne sur le formulaire de login en affichant les messages d'erreurs
            // Pas optimisé -> à revoir
            return back()->withErrors([
                'email' => 'Informations incorrects',
                'password' => 'Informations incorrects',
                ]);
            }
            
        }
        
     // Accès au profil et aux infos de l'utilisateur   
    public function show ($id) {

        $user = Utilisateurs::findOrFail($id);
        
        return view('profil', [

            'user' => $user,
        ]);
        
    }

    public function logout () {

        Auth::logout();

        return redirect()->route('login')->with('success', 'Utilisateur déconnecté');
    }
    
}
