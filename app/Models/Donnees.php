<?php

namespace App\Models;

use CodeIgniter\Model;

class Donnees extends Model
{
	protected $db;

	function __construct()
	{
		parent::__construct();
		$this->db = \Config\database::connect();
	}

	function getLesProgrammes()
	{
		$req = 'SELECT id, libelle FROM `programme`';
		$rs = $this->db->query($req);
		$general = $rs->getResultArray();
		return $general;
	}

	function getUneProgramme($idProgramme)
	{
		$req = 'SELECT id, libelle FROM `programme` WHERE id=?';
		$rs = $this->db->query($req, $idProgramme);
		$general = $rs->getRowArray();
		return $general;
	}

	function getLesExercices()
	{
		$req = 'SELECT id, idProgramme, libelle, charge, nbSeries FROM `exercice`';
		$rs = $this->db->query($req);
		$general = $rs->getResultArray();
		return $general;
	}

	public function getExercicesParProgramme($idProgramme)
	{
		return $this
			->db
			->table('exercice')
			->where('idProgramme', $idProgramme)
			->where('estActif', 1)
			->orderBy('ordre', 'ASC')
			->get()
			->getResultArray();
	}

	public function getUnExercice($id)
	{
		return $this->db->table('exercice')->where('id', $id)->get()->getRowArray();
	}

	function getLesSeances()
	{
		$req = 'SELECT s.id, libelle, date_seance, status FROM `seances` s JOIN programme c ON s.idProgramme=c.id ORDER BY date_seance DESC, id DESC';
		$rs = $this->db->query($req);
		$general = $rs->getResultArray();
		return $general;
	}

	function getUneSeances($id)
	{
		$req = "SELECT c.libelle AS titre, s.date_seance AS date, e.libelle, GROUP_CONCAT(p.reps ORDER BY p.numero_serie ASC SEPARATOR ', ') as liste_reps, GROUP_CONCAT(p.poids_effectif ORDER BY p.numero_serie ASC SEPARATOR ', ') as liste_poids FROM performances p JOIN exercice e ON p.idExercice = e.id JOIN seances s ON s.id=p.idSeance JOIN programme c ON c.id=s.idProgramme WHERE p.idSeance = ? GROUP BY e.id, e.libelle ORDER BY e.id ASC";
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

	public function getPerformancesRealisees($idSeance)
	{
		$query = $this
			->db
			->table('performances')
			->where('idSeance', $idSeance)
			->get()
			->getResultArray();
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