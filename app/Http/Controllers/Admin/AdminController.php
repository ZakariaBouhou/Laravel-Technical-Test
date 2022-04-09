<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Utilisateurs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    public function browse () {

        $utilisateurs = DB::table('utilisateurs')->where('role', '=', 'ROLE_USER')->orderBy('id','DESC')->get();     

        return view('admin\browse', [   

            'utilisateurs' => $utilisateurs,

        ]);

    }

    public function createView () {

        //dd(Auth::user());
        return view('admin\create');
        
    }

    public function create (Request $request) {
        
        
        $password = hash::make($request->password);

        $this->validate($request, [

            'name' => 'required',
            'email' => ['required', 'email', 'unique:Utilisateurs'],
            'password' => ['required', 'confirmed', Password::min(8)],

        ]);
        
        $utilisateur = new Utilisateurs();

        $utilisateur->name = $request->input('name');
        $utilisateur->email = $request->input('email');
        $utilisateur->password = hash::make($request->input('password'));

        $utilisateur->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $password
        ]);

        return redirect()->route('browse')->with('success', 'Nouvel utilisateur crée');
        
    }

    public function update (Request $request, $id) {
        
        $this->validate($request, [
            
            'name' => ['min:3', 'max:255'],
            'email' => 'email',
        ]);
        
        $utilisateur = Utilisateurs::find($id);

        $utilisateur->name = $request->input('name');
        $utilisateur->email = $request->input('email');

        $utilisateur->update();

        return redirect()->route('admin\browse')>with('success', 'Informations modifiées');
        
    }

    public function forceDelete ($id) {
        
        $utilisateur = Utilisateurs::findOrFail($id);
        $utilisateur->forceDelete();
        
    
        return redirect()->route('browse')->with('success', 'Utilisateur définitivement supprimé');
        
    }
}
