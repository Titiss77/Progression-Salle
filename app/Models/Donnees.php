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

	/**
	 * Retourne les informations générales du blog
	 *
	 * @return nom du club, description, nombre de nageurs, nombre d'hommes, nombre de femmes sous la forme d'un tableau associatif
	 */
	function getFirst() {
		$req = '
		SELECT debut
		FROM `first`
		';
		$rs = $this->db->query($req);
		$general = $rs->getRowArray();
		return $general;
	}
}