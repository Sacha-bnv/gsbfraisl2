<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

// Afficher le formulaire d'authentification 
//Route::get('/getLogin', 'ConnexionController@getLogin');
Route::get('/getLogin', function () {
   return view ('formLogin');
});
// Authentifie le visiteur à partir du login et mdp saisis
Route::post('/login', 'ConnexionController@logIn');

// Afficher les 12 derniers mois afin d'en selectionner un
Route::get('/getSuiviFrais', 'getSuiviFraisController@getFraisVisiteur');

// Afficher la liste des visiteurs et délégués de la région d'un responsable
Route::get('/getGererVisiteurs', 'getGererVisiteurController@getVisiteurSecteur');

// Déloguer le visiteur
Route::get('/Logout', 'ConnexionController@logOut');

//Afficher le formulaire de changement de mot de ppase
Route::get('/getChangerMdp', function () {
   return view ('formChangerMdp');
});

//Changer de mot de passe
Route::post('/changerMdp', 'ChangerMdpController@changePwd');

//Modifier la région et/ou le rôle
Route::post('/creerAffectation', 'getGererVisiteurController@creerAffectation');

//saisirFrais
Route::get('/saisirFraisForfait', 'FraisForfaitController@saisirFraisForfait');

//saisirFrais
Route::post('/saisirFraisForfait', 'FraisForfaitController@validerFraisForfait');

// Afficher la liste des fiches de Frais du visiteur connecté
Route::get('/getListeFrais', 'VoirFraisController@getFraisVisiteur');

// Afficher le détail de la fiche de frais pour le mois sélectionné
Route::get('/voirDetailFrais/{mois}', 'VoirFraisController@voirDetailFrais');

Route::get('/getLesFrais/{mois}', 'getSuiviFraisController@getLesFrais');

Route::get('/getUnVisiteur/{id}', 'getGererVisiteurController@getUnVisiteur');

// Afficher la liste des frais hors forfait d'une fiche de Frais
Route::get('/getListeFraisHorsForfait/{mois}', 'FraisHorsForfaitController@getFraisHorsForfait');

// Afficher le formulaire d'un Frais Hors Forfait pour une modification
Route::get('/modifierFraisHorsForfait/{idFrais}', 'FraisHorsForfaitController@modifierFraisHorsForfait');

// Afficher le formulaire d'un Frais Hors Forfait pour un ajout
Route::get('/ajouterFraisHorsForfait/{mois}', 'FraisHorsForfaitController@saisirFraisHorsForfait');

// Enregistrer une modification ou un ajout d'un Frais Hors Forfait
Route::post('/validerFraisHorsForfait', 'FraisHorsForfaitController@validerFraisHorsForfait');

// Supprimer un Frais Hors Forfait
Route::get('/supprimerFraisHorsForfait/{idFrais}', 'FraisHorsForfaitController@supprimmerFraisHorsForfait');

// Retourner à une vue dont on passe le nom en paramètre
Route::get('getRetour/{retour}', function($retour){
    return redirect("/".$retour);
});

//Nouveau Visiteur
Route::post('/nouveauVisiteur', 'NouveauVisiteurController@newVisiteur');

//Nouveau Visiteur Region
Route::get('/nouveauVisiteur', 'NouveauVisiteurController@getlesRegions');

// Afficher la liste des fiches de Frais du visiteur connecté
Route::get('/getValiderFrais', 'ValiderFicheFraisController@getVisiteurValiderFrais');

//saisirFrais
Route::post('/ModifierFraisForfait', 'ValiderFicheFraisController@ModifierFraisForfait');

//Afficher le formulaire de la modifications personnelles
Route::get('/getModifications', function () {
   return view ('formModificationsVisiteur');
});

Route::get('/getModifications','ModificationsVisiteurController@initVisiteur');

//Nouveau Visiteur
Route::post('/modificationsVisiteur', 'ModificationsVisiteurController@modifVisiteur');
