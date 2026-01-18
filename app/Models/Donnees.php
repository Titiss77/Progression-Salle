<?php

namespace App\Models;

use CodeIgniter\Model;

class Donnees extends Model
{
	protected $db;

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->db = \Config\database::connect();
	}

	function getLesCategories()
	{
		$req = 'SELECT id, libelle FROM `categorie`';
		$rs = $this->db->query($req);
		$general = $rs->getResultArray();
		return $general;
	}

	function getUneCategorie($idCategorie)
	{
		$req = 'SELECT id, libelle FROM `categorie` WHERE id=?';
		$rs = $this->db->query($req, $idCategorie);
		$general = $rs->getRowArray();
		return $general;
	}

	function getLesExercices()
	{
		$req = 'SELECT id, idCategorie, libelle, charge, nbSeries FROM `exercice`';
		$rs = $this->db->query($req);
		$general = $rs->getResultArray();
		return $general;
	}

	public function getExercicesParCategorie($idCategorie)
{
    return $this->db->table('exercice')
                    ->where('idCategorie', $idCategorie)
                    ->where('estActif', 1) // AJOUT : On ne prend que les actifs
                    ->get()
                    ->getResultArray();
}

	public function getUnExercice($id)
{
    return $this->db->table('exercice')->where('id', $id)->get()->getRowArray();
}

	function getLesSeances()
	{
		$req = 'SELECT s.id, libelle, date_seance, status FROM `seances` s JOIN categorie c ON s.idCategorie=c.id ORDER BY date_seance DESC';
		$rs = $this->db->query($req);
		$general = $rs->getResultArray();
		return $general;
	}

	function getUneSeances($id)
	{
		$req = "SELECT c.libelle AS titre, s.date_seance AS date, e.libelle, GROUP_CONCAT(p.reps ORDER BY p.numero_serie ASC SEPARATOR ', ') as liste_reps, GROUP_CONCAT(p.poids_effectif ORDER BY p.numero_serie ASC SEPARATOR ', ') as liste_poids FROM performances p JOIN exercice e ON p.idExercice = e.id JOIN seances s ON s.id=p.idSeance JOIN categorie c ON c.id=s.idCategorie WHERE p.idSeance = ? GROUP BY e.id, e.libelle ORDER BY e.id ASC";
		$rs = $this->db->query($req, [$id]);
		$general = $rs->getResultArray();
		return $general;
	}

	public function getSimpleSeance($idSeance)
	{
		return $this
			->db
			->table('seances')
			->where('id', $idSeance)
			->get()
			->getRowArray();
	}

	// Dans App/Models/Donnees.php

	public function getPerformancesRealisees($idSeance)
	{
		$query = $this
			->db
			->table('performances')
			->where('idSeance', $idSeance)
			->get()
			->getResultArray();

		// On réorganise le tableau pour qu'il soit facile à lire dans la Vue
		// Structure : [ ID_EXO => [ NUM_SERIE => [ 'reps'=>10, 'poids'=>60 ] ] ]
		$perfsOrdonnees = [];

		foreach ($query as $row) {
			$perfsOrdonnees[$row['idExercice']][$row['numero_serie']] = [
				'reps' => $row['reps'],
				'poids' => $row['poids_effectif']
			];
		}

		return $perfsOrdonnees;
	}
}