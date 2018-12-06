<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\metier\GsbFrais;
class NouveauVisiteurController extends Controller
{
    /**
     * Modifie le mot de passe de l'utilisateur
     * @return type Vue formLogin ou home
     */
    public function newVisiteur(Request $request){        
        $nom = $request->input('nom');
        $prenom = $request->input('prenom');
        $adresse = $request->input('adresse');
        $cp = $request->input('cp');
        $ville = $request->input('ville');
        $dateEmbauche = $request->input('dateEmbauche');
        $tel = $request->input('tel');
        $email = $request->input('email');
        $id = $request->input('id');
        $role = $request->input('role');
        $regionAffectation = $request->input('regionAffectation');
        
        $mdp = Hash::make(str_random(6));
        
        $gsbFrais = new GsbFrais();
        $res = $gsbFrais->getInfosVisiteur($nom,$prenom,$adresse,$cp,$ville,$dateEmbauche,$tel,$email,$id,$role,$regionAffectation,$login,$mdp);
        if(empty($res)){
            Session::put('id', '0');
            $erreur = "Login ou mot de passe inconnu !";
            //Session::flash('erreur', $erreur);
            // return back()->withInput($request->except('pwd'));
            return back()->with('erreur', $erreur);
        }
        else{
            $visiteur = $res[0];
            $id = $visiteur->id;
            $nom =  $visiteur->nom;
            $prenom = $visiteur->prenom;
            Session::put('id', $id);
            Session::put('nom', $nom);
            Session::put('prenom', $prenom);
            Session::put('login', $login);
//            return view('home');
            return redirect('/');
        }
        
    }
}
