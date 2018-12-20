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
    public function getlesRegions(){
        
        $sec_code = session::get('sec_code');
        $gsbFrais = new GsbFrais();
        $lesregions = $gsbFrais->getRegions($sec_code);
        return view('formNouveauVisiteur', compact('lesregions'));
        
    }
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
        $region = $request->input('region');
        
       
        
        if (strpos($nom,"-")) {
            $login = substr($prenom, 0, strpos($nom,"-")-1).$nom;
        }
        else{

            $login = substr($prenom, 0, 1).$nom;
        }
        
        //mdp aléatoire 
        $chiffreShuffle = str_shuffle("1234567890");
        $minusShuffle = str_shuffle("azertyuiopqsdfghjklmwxcvbn");
        $majShuffle = str_shuffle("AZERTYUIOPQSDFGHJKLMWXCVBN");
 
        //ne prend que les 6 premier caractères 
        $pass1 = substr($chiffreShuffle,0,1);
        $pass2 = substr($minusShuffle,0,3);
        $pass3 = substr($majShuffle,0,2);
        
        $pass = $pass1.$pass2.$pass3;
        $passShuffle = str_shuffle($pass);
        
        $today = date("Y-m-d");

        
        $gsbFrais = new GsbFrais();
        $res = $gsbFrais->getInfosNouveauVisiteur($id);
        
        if ($res) {
            $erreur = "ID visiteur existe deja !";
            return back()->with('erreur', $erreur);
            
        }
        else{
            $gsbFrais->creerNouveauVisiteur($id,$nom,$prenom,$login,MD5($passShuffle),$adresse,$cp,$ville,$dateEmbauche,$tel,$email);
            $gsbFrais->creerNouveauTravailler($id,$today,$region,$role);
            return back()->with('status', "Mise à jour effectué, Login: $login Mdp: $passShuffle");
        }
        
           
            

            

        
    }
}
