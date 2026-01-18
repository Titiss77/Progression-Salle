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

	public function ajouterPerformances($data)
	{
		// insertBatch permet d'insérer un tableau de tableaux en une seule requête SQL
		return $this->db->table('performances')->insertBatch($data);
	}

	// Dans App/Models/ActionInDB.php

	public function updateStatusSeance($idSeance, $status)
	{
		return $this
			->db
			->table('seances')
			->where('id', $idSeance)
			->update(['status' => $status]);
	}

	// Optionnel mais recommandé : Nettoyer les anciennes perfs avant de sauvegarder
	// (pour éviter les doublons si on clique 2 fois sur sauvegarder)
	public function nettoyerPerformances($idSeance)
	{
		return $this->db->table('performances')->where('idSeance', $idSeance)->delete();
	}
}