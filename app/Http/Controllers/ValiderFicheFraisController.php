<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Exception;
use App\metier\GsbFrais;

class ValiderFicheFraisController extends Controller
{
    public function getValiderFrais() {
        //$erreur = Session::get('erreur');
        //Session::forget('erreur');
        $date = date("Y/m/d");
        $moins1An = date("d/m/Y", strtotime("-1 year", strtotime($date)));
        //echo $moins1An;
        $numAnnee =substr( $moins1An,6,4);
        $numMois =substr( $moins1An,3,2);
        $mois = $numAnnee.$numMois;
        $unFrais = new GsbFrais();
        $id_visiteur = Session::get('id');
        // On récupère la liste de tous les frais sur une année glissante
        $mesFrais = $unFrais->getLesFrais($id_visiteur, $mois);
        // On affiche la liste de ces frais       
        return view('validerFicheFrais', compact('mesFrais'));
    }
    
    
  
    public function ModifierFraisForfait() {
        $date = date("d/m/Y");
        $numAnnee =substr( $date,6,4);
        $numMois =substr( $date,3,2);
        $mois = $numAnnee.$numMois;
        $idVisiteur = Session::get('id');
        $gsbFrais = new GsbFrais();
        if ($gsbFrais->estPremierFraisMois($idVisiteur,$mois)){
            $gsbFrais->creeNouvellesLignesFrais($idVisiteur,$mois);
        }
        $lesFrais = $gsbFrais->getLesFraisForfait($idVisiteur, $mois);
//        print_r($lesFrais);
        // Affiche le formulaire en lui fournissant les données à afficher
        // la fonction compact équivaut à array('lesFrais' => $lesFrais, ...) 
        return redirect()->back()->with('status', 'Modification efféctuée!');
    }
    
      public function getVisiteurValiderFrais() {
        $gsbfrais = new GsbFrais();
        //$region= Session::get('region');
        $region=  Session::get('region');
        $visiteurs=$gsbfrais->getVisiteurRegion($region);
        print_r($visiteurs);
        return view('listeFraisVisiteur', compact('visiteurs'));
    }
    
}