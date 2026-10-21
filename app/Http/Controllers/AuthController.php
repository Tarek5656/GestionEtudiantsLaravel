<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    //
     public function show(){ 
        return view('login'); 
    } 
    public function login(Request $request){ 
            $login =$request->email; 
            $password=$request->password; 
            $credentials=['email'=>$login, 'password'=>$password]; 
 
            if(Auth::attempt($credentials)){ 
                $request->session()->regenerate(); 
                if (auth()->user()->role === 'admin') {
                    return to_route('admin.dashboard')->with('success','Vous êtes bien connecté '.auth()->user()->name.' !'); 
                }
                else if (auth()->user()->role === 'user') {
                    return to_route('user.profile', auth()->user()->etudiant->id)->with('success','Vous êtes bien connecté '.auth()->user()->etudiant->nom.' '.auth()->user()->etudiant->prenom.' !'); 
                } 
            }
            return back()->withErrors(['email'=>'Email ou mots de passe est incorrect']) 
            ->onlyInput('email'); 
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->name;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->update();

        return back()->with('success', 'Vos informations ont été mises à jour avec succès !');
    }

     public function logout(){ 
        Session::flush(); 
        Auth::logout(); 
        return to_route('login.show')->with('success','Vous êtes bien déconnecté'); 
    }
}
