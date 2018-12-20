<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Exception;
use App\metier\GsbFrais;

class getGererVisiteurController extends Controller
{
     /**
     * Affiche la liste de tous les visiteurs
     * et délégués de la région du responsable
     * Si une erreur a été stockée dans la Session
     * on la récupère, on l'efface de la Session
     * et la passe au formulaire
     * @return type Vue listeFrais
     */
    public function getVisiteurSecteur() {
        $unFrais = new GsbFrais();
        $idSession = Session::get('id');
        // On récupère la liste de tous les visiteurs d'un secteur
        $lesVisiteurs = $unFrais->getVisiteursSecteur($idSession);  
        return view('VisiteursSecteur', compact('lesVisiteurs'));
    }
    
    public function getUnVisiteur($id) {
        $unFrais = new GsbFrais();
        $id_visiteur = $id;
        $secteur = Session::get('secteur');
        // On récupère les informations du visiteurs/délégué
        $lesInfos = $unFrais->getGererInfosVisiteur($id);
        $lesRegions = $unFrais->getRegion($secteur);
        //Met l'id du visiteur séléctionné dans une variable de session de manière à la réutiliser dans la fonction changerRegionRole
        Session::put('idVisiteur', $id_visiteur);
        return view('gererVisiteur', compact('lesInfos', 'lesRegions'));
    }
    
    //Créer une affectation
    public function creerAffectation(Request $request){        
        // récupérer les variables
        $role = $request->input('role');
        $region = $request->input('region');
        $region = substr($region, 0, 2);
        $idVisiteur = Session::get('idVisiteur');
        $gsbFrais = new GsbFrais();
        //NOTE: La contrainte de clé étrangère ne permet de créer qu'une seule affectation par jour et par travailleur
        $gsbFrais->creerAffectation($idVisiteur, $role, $region);
        return back()->with('status', 'Mise à jour effectuée!');        
    }
  
}