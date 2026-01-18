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

	function getLesExercices()
	{
		$req = 'SELECT id, idCategorie, libelle, charge, nbSeries FROM `exercice`';
		$rs = $this->db->query($req);
		$general = $rs->getResultArray();
		return $general;
	}

	function getLesSeances()
	{
		$req = 'SELECT libelle, date_seance FROM `seances` s JOIN categorie c ON s.idCategorie=c.id ORDER BY date_seance DESC';
		$rs = $this->db->query($req);
		$general = $rs->getResultArray();
		return $general;
	}
}