<?php
namespace App\metier;

use Illuminate\Support\Facades\DB;

/** 
 * Classe d'accès aux données. 
 */
class GsbFrais{   		
/**
 * Retourne les informations d'un visiteur
 
 * @param $login 
 * @param $mdp
 * @return l'id, le nom et le prénom sous la forme d'un objet 
*/
public function getInfosVisiteur($login, $mdp){
        $req = "select visiteur.id as id, visiteur.nom as nom, visiteur.prenom as prenom, vaffectation.tra_role as role, vaffectation.reg_nom as region, vaffectation.sec_nom as sec_nom, vaffectation.sec_code as sec_code, vaffectation.tra_reg as reg_code from visiteur inner join vaffectation on vaffectation.idVisiteur = visiteur.id
        where visiteur.login=:login and visiteur.mdp=:mdp";
        $ligne = DB::select($req, ['login'=>$login, 'mdp'=>$mdp]);
        return $ligne;
}
/**
 * Retourne sous forme d'un tableau d'objets toutes les lignes de frais hors forfait
 * concernées par les deux arguments
 
 * La boucle foreach ne peut être utilisée ici car on procède
 * à une modification de la structure itérée - transformation du champ date-
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return un objet avec tous les champs des lignes de frais hors forfait 
*/
	public function getLesFraisHorsForfait($idVisiteur,$mois){
	    $req = "select * from lignefraishorsforfait where lignefraishorsforfait.idvisiteur =:idVisiteur 
		and lignefraishorsforfait.mois = :mois ";	
            $lesLignes = DB::select($req, ['idVisiteur'=>$idVisiteur, 'mois'=>$mois]);
//            for ($i=0; $i<$nbLignes; $i++){
//                    $date = $lesLignes[$i]['date'];
//                    $lesLignes[$i]['date'] =  dateAnglaisVersFrancais($date);
//            }
            return $lesLignes; 
	}
/**
 * Retourne sous forme d'un tableau associatif toutes les lignes de frais au forfait
 * concernées par les deux arguments
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return un objet contenant les frais forfait du mois
*/
	public function getLesFraisForfait($idVisiteur, $mois){
		$req = "select fraisforfait.id as idfrais, fraisforfait.libelle as libelle, ligneFraisForfait.mois as mois,
		lignefraisforfait.quantite as quantite from lignefraisforfait inner join fraisforfait 
		on fraisforfait.id = lignefraisforfait.idFraisForfait
		where lignefraisforfait.idvisiteur = :idVisiteur and lignefraisforfait.mois=:mois
		order by lignefraisforfait.idfraisforfait";	
//                echo $req;
                $lesLignes = DB::select($req, ['idVisiteur'=>$idVisiteur, 'mois'=>$mois]);
		return $lesLignes; 
	}
/**
 * Retourne tous les id de la table FraisForfait
 * @return un objet avec les données de la table frais forfait
*/
	public function getLesIdFrais(){
		$req = "select fraisforfait.id as idfrais from fraisforfait order by fraisforfait.id";
		$lesLignes = DB::select($req);
		return $lesLignes;
	}
/**
 * Met à jour la table ligneFraisForfait
 
 * Met à jour la table ligneFraisForfait pour un visiteur et
 * un mois donné en enregistrant les nouveaux montants
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @param $lesFrais tableau associatif de clé idFrais et de valeur la quantité pour ce frais
*/
	public function majFraisForfait($idVisiteur, $mois, $lesFrais){
		$lesCles = array_keys($lesFrais);
    //            print_r($lesFrais);
		foreach($lesCles as $unIdFrais){
			$qte = $lesFrais[$unIdFrais];
			$req = "update lignefraisforfait set lignefraisforfait.quantite = :qte
			where lignefraisforfait.idvisiteur = :idVisiteur and lignefraisforfait.mois = :mois
			and lignefraisforfait.idfraisforfait = :unIdFrais";
                        DB::update($req, ['qte'=>$qte, 'idVisiteur'=>$idVisiteur, 'mois'=>$mois, 'unIdFrais'=>$unIdFrais]);
		}
		
	}
/**
 * met à jour le nombre de justificatifs de la table ficheFrais
 * pour le mois et le visiteur concerné
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
*/
	public function majNbJustificatifs($idVisiteur, $mois, $nbJustificatifs){
		$req = "update fichefrais set nbjustificatifs = :nbJustificatifs 
		where fichefrais.idvisiteur = :idVisiteur and fichefrais.mois = :mois";
		DB::update($req, ['nbJustificatifs'=>$nbJustificatifs, 'idVisiteur'=>$idVisiteur, 'mois'=>$mois]);	
	}
/**
 * Teste si un visiteur possède une fiche de frais pour le mois passé en argument
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return vrai ou faux 
*/	
	public function estPremierFraisMois($idVisiteur,$mois)
	{
		$ok = false;
		$req = "select count(*) as nblignesfrais from fichefrais 
		where fichefrais.mois = :mois and fichefrais.idvisiteur = :idVisiteur";
		$laLigne = DB::select($req, ['idVisiteur'=>$idVisiteur, 'mois'=>$mois]);
                $nb = $laLigne[0]->nblignesfrais;
		if($nb == 0){
			$ok = true;
		}
		return $ok;
	}
/**
 * Retourne le dernier mois en cours d'un visiteur
 
 * @param $idVisiteur 
 * @return le mois sous la forme aaaamm
*/	
	public function dernierMoisSaisi($idVisiteur){
		$req = "select max(mois) as dernierMois from fichefrais where fichefrais.idvisiteur = :idVisiteur";
		$laLigne = DB::select($req, ['idVisiteur'=>$idVisiteur]);
                $dernierMois = $laLigne[0]->dernierMois;
		return $dernierMois;
	}
	
/**
 * Crée une nouvelle fiche de frais et les lignes de frais au forfait pour un visiteur et un mois donnés
 
 * récupère le dernier mois en cours de traitement, met à 'CL' son champs idEtat, crée une nouvelle fiche de frais
 * avec un idEtat à 'CR' et crée les lignes de frais forfait de quantités nulles 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
*/
	public function creeNouvellesLignesFrais($idVisiteur,$mois){
		$dernierMois = $this->dernierMoisSaisi($idVisiteur);
		$laDerniereFiche = $this->getLesInfosFicheFrais($idVisiteur,$dernierMois);
		if($laDerniereFiche->idEtat=='CR'){
				$this->majEtatFicheFrais($idVisiteur, $dernierMois,'CL');
				
		}
		$req = "insert into fichefrais(idvisiteur,mois,nbJustificatifs,montantValide,dateModif,idEtat) 
		values(:idVisiteur,:mois,0,0,now(),'CR')";
		DB::insert($req, ['idVisiteur'=>$idVisiteur, 'mois'=>$mois]);
		$lesIdFrais = $this->getLesIdFrais();
		foreach($lesIdFrais as $uneLigneIdFrais){
			$unIdFrais = $uneLigneIdFrais->idfrais;
			$req = "insert into lignefraisforfait(idvisiteur,mois,idFraisForfait,quantite) 
			values(:idVisiteur,:mois,:unIdFrais,0)";
			DB::insert($req, ['idVisiteur'=>$idVisiteur, 'mois'=>$mois, 'unIdFrais'=>$unIdFrais]);
		 }
	}
/**
 * Crée un nouveau frais hors forfait pour un visiteur un mois donné
 * à partir des informations fournies en paramètre
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @param $libelle : le libelle du frais
 * @param $date : la date du frais au format français jj//mm/aaaa
 * @param $montant : le montant
*/
	public function creeNouveauFraisHorsForfait($idVisiteur,$mois,$libelle,$date,$montant){
//		$dateFr = dateFrancaisVersAnglais($date);
		$req = "insert into lignefraishorsforfait(idVisiteur, mois, libelle, date, montant) 
		values(:idVisiteur,:mois,:libelle,:date,:montant)";
		DB::insert($req, ['idVisiteur'=>$idVisiteur, 'mois'=>$mois, 'libelle'=>$libelle,'date'=>$date,'montant'=>$montant]);
	}

/**
 * Récupère le frais hors forfait dont l'id est passé en argument
 * @param $idFrais 
 * @return un objet avec les données du frais hors forfait
*/
	public function getUnFraisHorsForfait($idFrais){
		$req = "select * from lignefraishorsforfait where lignefraishorsforfait.id = :idFrais ";
		$fraisHF = DB::select($req, ['idFrais'=>$idFrais]);
//                print_r($unfraisHF);
                $unFraisHF = $fraisHF[0];
                return $unFraisHF;
	}
/**
 * Modifie frais hors forfait à partir de son id
 * à partir des informations fournies en paramètre
 * @param $id 
 * @param $libelle : le libelle du frais
 * @param $date : la date du frais au format français jj//mm/aaaa
 * @param $montant : le montant
*/
	public function modifierFraisHorsForfait($id, $libelle,$date,$montant){
//		$dateFr = dateFrancaisVersAnglais($date);
		$req = "update lignefraishorsforfait set libelle = :libelle, date = :date, montant = :montant
		where id = :id";
		DB::update($req, ['libelle'=>$libelle,'date'=>$date,'montant'=>$montant, 'id'=>$id]);
	}
        
/**
 * Supprime le frais hors forfait dont l'id est passé en argument
 * @param $idFrais 
*/
	public function supprimerFraisHorsForfait($idFrais){
		$req = "delete from lignefraishorsforfait where lignefraishorsforfait.id = :idFrais ";
		DB::delete($req, ['idFrais'=>$idFrais]);
	}
/**
 * Retourne les fiches de frais d'un visiteur à partir d'un certain mois
 * @param $idVisiteur 
 * @param $mois mois début
 * @return un objet avec les fiches de frais de la dernière année
*/
	public function getLesFrais($idVisiteur, $mois){
		$req = "select * from  fichefrais where idvisiteur = :idVisiteur
                and  mois >= :mois   
		order by fichefrais.mois desc ";
                $lesLignes = DB::select($req, ['idVisiteur'=>$idVisiteur, 'mois'=>$mois]);
                return $lesLignes;
	}
        
        /**
 * Retourne les fiches de frais des visiteurs à partir d'un certain mois pour la région du délégué
 * @param $idVisiteur 
 * @param $mois mois début
 * @return un objet avec les fiches de frais de la dernière année
*/
        
        public function getTousLesFraisDel($mois, $id){
		$req = "select DISTINCT visiteur.nom, visiteur.prenom, mois, nbJustificatifs, montantValide, idEtat, visiteur.id from fichefrais 
                            inner join visiteur on fichefrais.idVisiteur = visiteur.id
                            inner join travailler on travailler.idVisiteur = visiteur.id
                            inner join region on travailler.tra_reg = region.id
                            inner join secteur on region.sec_code = secteur.id
                            where mois = :mois and visiteur.id in (SELECT idVisiteur from vaffectation where tra_reg = (SELECT tra_reg FROM vaffectation WHERE idVisiteur = :id) and tra_role = 'Visiteur') 
                            order by fichefrais.mois desc";
                $lesLignes = DB::select($req, ['mois'=>$mois, 'id'=>$id]);
                return $lesLignes;
	}
        
 /**
 * Retourne les fiches de frais des délégués et visiteurs à partir d'un certain mois pour le secteur du responsable
 * @param $idVisiteur 
 * @param $mois mois début
 * @return un objet avec les fiches de frais de la dernière année
*/
        
        public function getTousLesFraisRes($mois, $id){
		$req = "select DISTINCT visiteur.nom, visiteur.prenom, mois, nbJustificatifs, montantValide, idEtat, visiteur.id from fichefrais 
                            inner join visiteur on fichefrais.idVisiteur = visiteur.id
                            inner join travailler on travailler.idVisiteur = visiteur.id
                            inner join region on travailler.tra_reg = region.id
                            inner join secteur on region.sec_code = secteur.id
                            where mois = :mois and visiteur.id in (SELECT idVisiteur from vaffectation where sec_code = (SELECT sec_code FROM vaffectation WHERE idVisiteur = :id) and tra_role != 'Responsable')
                            order by fichefrais.mois desc";
                $lesLignes = DB::select($req, ['mois'=>$mois, 'id'=>$id]);
                return $lesLignes;
	}
        
         /**
 * Retourne le nom et prenom des visiteurs et délégués de la même région du responsable
 * @param $id 
 * @return un objet avec les fiches de frais de la dernière année
*/
        
        public function getVisiteursSecteur($id){
		$req = "SELECT id, nom, prenom FROM visiteur WHERE id in (SELECT idVisiteur FROM vaffectation WHERE sec_code =
                        (SELECT sec_code FROM vaffectation WHERE idVisiteur = :id)
                        && tra_role != 'Responsable')";
                $lesLignes = DB::select($req, ['id'=>$id]);
                return $lesLignes;
	}
        
        /**
 * Retourne le nom et prenom, region, rôle d'un visiteur séléctionné
 * @param $id 
 * @return un objet avec les infos d'un visiteur
*/
        
        public function getGererInfosVisiteur($id){
		$req = "SELECT nom, prenom, tra_reg, tra_role FROM vaffectation
                        INNER JOIN visiteur ON visiteur.id = vaffectation.idVisiteur
                        WHERE idVisiteur = :id";
                $lesLignes = DB::select($req, ['id'=>$id]);
                return $lesLignes;
	}
        
        /**
 * Retourne les regions appartenant à un secteur
 * @param $secteur 
 * @return un objet avec les noms des régions
*/
        
        public function getRegion($secteur){
		$req = "SELECT reg_nom, region.id as reg_id from region
                        INNER JOIN secteur on secteur.id = region.sec_code
                        WHERE secteur.sec_nom = :secteur";
                $lesLignes = DB::select($req, ['secteur'=>$secteur]);
                return $lesLignes;
	}
/**
 * Retourne les informations d'une fiche de frais d'un visiteur pour un mois donné
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return un objet avec des champs de jointure entre une fiche de frais et la ligne d'état 
*/	
	public function getLesInfosFicheFrais($idVisiteur,$mois){
		$req = "select ficheFrais.idEtat as idEtat, ficheFrais.dateModif as dateModif, ficheFrais.nbJustificatifs as nbJustificatifs, 
			ficheFrais.montantValide as montantValide, etat.libelle as libEtat from  fichefrais inner join Etat on ficheFrais.idEtat = Etat.id 
			where fichefrais.idvisiteur = :idVisiteur and fichefrais.mois = :mois";
		$lesLignes = DB::select($req, ['idVisiteur'=>$idVisiteur,'mois'=>$mois]);			
		return $lesLignes[0];
	}
/** 
 * Modifie l'état et la date de modification d'une fiche de frais
 * Modifie le champ idEtat et met la date de modif à aujourd'hui
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 */
 
	public function majEtatFicheFrais($idVisiteur,$mois,$etat){
		$req = "update ficheFrais set idEtat = :etat, dateModif = now() 
		where fichefrais.idvisiteur = :idVisiteur and fichefrais.mois = :mois";
		DB::update($req, ['etat'=>$etat, 'idVisiteur'=>$idVisiteur, 'mois'=>$mois]);
	}
        
        public function majMotDePasse($idUser, $pwdUser){
            $req = "update visiteur set mdp = :mdp
            where visiteur.id = :idVisiteur";
            DB::update($req, ['mdp'=>$pwdUser, 'idVisiteur'=>$idUser]);
        }

        public function creerAffectation($id, $role, $region){
		$req = "INSERT INTO travailler VALUES (:id, DATE(now()), :region, :role)";
                $lesLignes = DB::select($req, ['id'=>$id, 'role'=>$role, 'region'=>$region]);
                return $lesLignes;
	}
/** 
 * Créer un nouveau visiteur dans la table visteur et travailler
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 */
        public function creerNouveauVisiteur($id,$nom,$prenom,$login,$mdp,$adresse,$cp,$ville,$dateEmbauche,$tel,$email){
            $req = "insert into visiteur(id,nom,prenom,login,mdp,adresse,cp,ville,dateEmbauche,tel,email) 
		values(:id,:nom,:prenom,:login,:mdp,:adresse,:cp,:ville,:dateEmbauche,:tel,:email)";
            DB::insert($req, ['id'=>$id,'nom'=>$nom,'prenom'=>$prenom,'login'=>$login,'mdp'=>$mdp,'adresse'=>$adresse,'cp'=>$cp,'ville'=>$ville,'dateEmbauche'=>$dateEmbauche,'tel'=>$tel,'email'=>$email]);
        }
        
        public function creerNouveauTravailler($idVisiteur,$tra_date,$tra_reg,$tra_role){
            $req = "insert into travailler(idVisiteur,tra_date,tra_reg,tra_role)
                    values(:idVisiteur,:tra_date,:tra_reg,:tra_role)";
            DB::insert($req, ['idVisiteur'=>$idVisiteur, 'tra_date'=>$tra_date, 'tra_reg'=>$tra_reg, 'tra_role'=>$tra_role]);
        }
        
        public function getInfosNouveauVisiteur($id){
            $req = "select * from visiteur where id = :id";
            $ligne = DB::select($req, ['id'=>$id]);
            return $ligne;
        }
 /** 
 * Permet de récupérer les tables pour la liste déroulante
 */
        public function getRegions($sec_code){
	$req = "select id,reg_nom from region where sec_code = :sec_code";
        $ligne = DB::select($req, ['sec_code'=>$sec_code]);
        return $ligne;
        }
        public function RoleEtRegion(){
            $req = "select distinct tra_role,reg_nom from  travailler inner join region on travailler.tra_reg = region.id";
            return $req;
	}
        
/** 
 * modifier un nouveau visiteur dans la table visteur
 */
        public function modifierNouveauVisiteur($id,$adresse,$cp,$ville,$tel,$email){
        $req = "update visiteur set adresse = :adresse, cp = :cp, ville = :ville, tel = :tel, email = :email
		where id = :id";
		DB::update($req, ['adresse'=>$adresse, 'cp'=>$cp, 'ville'=>$ville, 'tel'=>$tel, 'email'=>$email, 'id'=>$id]);
        }
        
        public function infosModifierNouveauVisiteur($id){
        $req = "select adresse,cp,ville,tel,email from visiteur where id = :id";
	$ligne = DB::select($req, ['id'=>$id]);
        return $ligne;
        }
        public function getVisiteurRegion($region){
	$req = "select * from  vaffectation INNER join fichefrais on vaffectation.idVisiteur=fichefrais.idVisiteur where vaffectation.reg_nom = :region and fichefrais.idEtat like 'CL'  GROUP by fichefrais.idVisiteur"  ;
        echo $req;
        $ligne = DB::select($req, ['region'=>$region]);
        //$ligne = DB::select($req);
        return $ligne;
	}
        
        
        
        
}
?>
