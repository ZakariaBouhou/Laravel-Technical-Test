<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Utilisateurs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{

    // Méthode qui va afficher tous les utilisateurs du back-office sauf celui de l'admin par sécurité
    public function browse () {
        
        $utilisateurs = DB::table('utilisateurs')->where('role', '=', 'ROLE_USER')->orderBy('id','DESC')->get();     

        return view('admin\browse', [   

            'utilisateurs' => $utilisateurs,

        ]);

    }

    // Méthode qui renvoie vers le formulaire d'ajout d'un utilisateur
    public function createView () {

        return view('admin\create');
        
    }

    // Formulaire d'ajout d'un utilisateur
    public function create (Request $request) {
        
        // Password hashé stockée dans une variable
        $password = hash::make($request->password);

        // On précise les ritères de validation
        $this->validate($request, [

            'name' => 'required',
            'email' => ['required', 'email', 'unique:Utilisateurs'],
            'password' => ['required', 'confirmed', Password::min(8)],

        ]);
        
        // On instancie un nouvel objet Utilisateurs
        $utilisateur = new Utilisateurs();

        // On récupère les valeurs des inputs dans les propriétés de l'objet
        $utilisateur->name = $request->input('name');
        $utilisateur->email = $request->input('email');
        $utilisateur->password = hash::make($request->input('password'));

        // On crée et sauvegarde les données en DB
        // Note : J'ai un doute sur cette façon de faire
        $utilisateur->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $password
        ]);

        return redirect()->route('browse')->with('success', 'Nouvel utilisateur crée');
        
    }

    // Formulaire d'édition d'un utilisateur
    public function update (Request $request, $id) {
        
        $this->validate($request, [
            
            'name' => ['min:3', 'max:255'],
            'email' => 'email',
        ]);
        
        // On récupère l'utilisateur courant
        $utilisateur = Utilisateurs::find($id);

        // ...Même opération que les lignes 55 plus haut
        $utilisateur->name = $request->input('name');
        $utilisateur->email = $request->input('email');

        // On met à jour les données en BDD
        $utilisateur->update();

        return redirect()->route('admin\browse')>with('success', 'Informations modifiées');
        
    }

    // Méthode qui va permettre la suppression définitive d'un utilisateur (de la BDD)
    // A contrario de la méthode SoftDelete qui va garder les informations d'un utilisateur en mémoire
    public function forceDelete ($id) {
        
        $utilisateur = Utilisateurs::findOrFail($id);
        $utilisateur->forceDelete();

        $currentRoute = Route::currentRouteName();


        // Si on supprime depuis le back-office, on sera redirigé vers le BO
        if ($currentRoute === 'browse') {

            return redirect()->route('browse')->with('success', 'Utilisateur définitivement supprimé');

        }

        // Sinon, si on supprime l'admin depuis son profil, on sera redirigé vers la page login
        else {

            return redirect()->route('login')->with('success', 'Utilisateur définitivement supprimé');

        }
        
        
    }
}
