<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\metier\GsbFrais;
class ChangerMdpController extends Controller
{
    /**
     * Modifie le mot de passe de l'utilisateur
     * @return type Vue formLogin ou home
     */
    public function changePwd(Request $request){        
        // récupérer les variables
        $login = session('login');
        $pwd = $request->input('pwd_actuel');
        $pwd_nouveau = $request->input('pwd_nouveau');
        $pwd_confirmer = $request->input('pwd_confirmer');
        $gsbFrais = new GsbFrais();
        $res = $gsbFrais->getInfosVisiteur($login,$pwd);
        
        //ajout commentaire
        if(empty($res))
        {
            $erreur = "Mot de passe incorrecte";
            return back()->with('erreur', $erreur);
        }
        else if($pwd_nouveau == $pwd)
        {
            $erreur = "Votre mot de passe doit être différent de l'ancien";   
            return back()->with('erreur', $erreur);
        }
        else if($pwd_nouveau != $pwd_confirmer)
        {
            $erreur = "Les mots de passe sont différents";   
            return back()->with('erreur', $erreur);          
        }
        else
        {
            $visiteur = $res[0];
            $id = $visiteur->id;
            //$gsbFrais->majMotDePasse($id, $pwd_nouveau);
            return redirect('/');
            //return back()->with('status', 'Mise à jour effectuée!');
        }
        
    }
}
