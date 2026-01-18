<?php 

namespace App\Models;

use CodeIgniter\Model;
class Donnees extends Model {
    protected $db ;

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
        $this->db = \Config\database::connect();
	}

	function getCategories() {
		$req = 'SELECT id, libelle FROM `categorie`';
		$rs = $this->db->query($req);
		$general = $rs->getResultArray();
		return $general;
	}

	function getExercices() {
		$req = 'SELECT id, idCategorie, libelle, charge, nbSeries FROM `exercice`';
		$rs = $this->db->query($req);
		$general = $rs->getResultArray();
		return $general;
	}
}