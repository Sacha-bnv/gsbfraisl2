<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\metier\GsbFrais;
class ModificationsVisiteurController extends Controller
{
    /**
     * Modifie le mot de passe de l'utilisateur
     * @return type Vue formLogin ou home
     */
    public function initVisiteur(){
        $id = session::get('id');
        $gsbFrais = new GsbFrais();
        $rec = $gsbFrais->infosModifierNouveauVisiteur($id);
        
        return view('formModificationsVisiteur', compact('rec'));
    }
    public function modifVisiteur(Request $request){        
        // récupérer les variables
        $id = Session::get('id');
        $adresse = $request->input('adresse');
        $cp = $request->input('cp');
        $ville = $request->input('ville');
        $tel = $request->input('tel');
        $email = $request->input('email');
        
        
        
        $gsbFrais = new GsbFrais();
        $res = $gsbFrais->getInfosNouveauVisiteur($id);

        //ajout commentaire
        if (!$res) {
            $erreur = "ID n'existe pas !";
            return back()->with('erreur', $erreur);
            
        }
        else{
            $gsbFrais->modifierNouveauVisiteur($id,$adresse,$cp,$ville,$tel,$email);
            return back()->with('status', "Mise à jour effectué");
        }
        
    }
}
