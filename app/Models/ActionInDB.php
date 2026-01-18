<?php

namespace App\Models;

use CodeIgniter\Model;

class ActionInDB extends Model
{
	protected $db;

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->db = \Config\database::connect();
	}

	public function setSeanceVide($idCategorie)
	{
		// 1. On prépare les données
		$data = [
			'idCategorie' => $idCategorie,
			'date_seance' => date('Y-m-d'),  // Met automatiquement la date d'aujourd'hui
		];

		// 2. On insère dans la table
		$this->db->table('seances')->insert($data);

		// 3. IMPORTANT : On retourne l'ID de la nouvelle ligne créée
		// Cela te permettra de rediriger l'utilisateur vers la page de cette séance précis
		return $this->db->insertID();
	}
}