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

	public function deleteExercice($id)
	{
		// SUPPRESSION LOGIQUE : On archive l'exercice au lieu de le supprimer
		return $this
			->db
			->table('exercice')
			->where('id', $id)
			->update(['estActif' => 0]);
	}

	public function saveExercice($data)
	{
		// CAS 1 : CRÉATION (Nouvel exercice)
		if (empty($data['id'])) {
			unset($data['id']);
			$data['estActif'] = 1;

			// Calcul du prochain numéro d'ordre pour cette catégorie
			$maxOrdre = $this
				->db
				->table('exercice')
				->where('idCategorie', $data['idCategorie'])
				->where('estActif', 1)
				->selectMax('ordre')
				->get()
				->getRowArray();

			$data['ordre'] = ($maxOrdre['ordre'] ?? 0) + 1;

			return $this->db->table('exercice')->insert($data);
		}
		// CAS 2 : MODIFICATION (On crée une nouvelle version)
		else {
			// A. On récupère l'ANCIEN exercice pour connaître son ordre actuel
			$oldExo = $this->db->table('exercice')->where('id', $data['id'])->get()->getRowArray();

			// B. On archive l'ancien
			$this
				->db
				->table('exercice')
				->where('id', $data['id'])
				->update(['estActif' => 0]);

			// C. On crée le NOUVEAU en copiant l'ordre de l'ancien
			$nouvelExercice = [
				'idCategorie' => $data['idCategorie'],
				'libelle' => $data['libelle'],
				'nbSeries' => $data['nbSeries'],
				'charge' => $data['charge'],
				'estActif' => 1,
				'ordre' => $oldExo['ordre']  // IMPORTANT : On garde la même position
			];

			return $this->db->table('exercice')->insert($nouvelExercice);
		}
	}

	public function changerOrdre($idExercice, $direction)
	{
		// 1. Récupérer l'exercice à déplacer
		$exercice = $this->db->table('exercice')->where('id', $idExercice)->get()->getRowArray();

		if (!$exercice)
			return;

		$ordreActuel = $exercice['ordre'];
		$idCategorie = $exercice['idCategorie'];

		// 2. Trouver le voisin avec qui échanger
		$builder = $this
			->db
			->table('exercice')
			->where('idCategorie', $idCategorie)
			->where('estActif', 1);

		if ($direction === 'monter') {
			// On cherche celui qui a un ordre juste INFÉRIEUR (ex: on est 5, on cherche le 4)
			$voisin = $builder
				->where('ordre <', $ordreActuel)
				->orderBy('ordre', 'DESC')  // Le plus proche
				->limit(1)
				->get()
				->getRowArray();
		} else {
			// On cherche celui qui a un ordre juste SUPÉRIEUR (ex: on est 5, on cherche le 6)
			$voisin = $builder
				->where('ordre >', $ordreActuel)
				->orderBy('ordre', 'ASC')  // Le plus proche
				->limit(1)
				->get()
				->getRowArray();
		}

		// 3. Echanger les ordres si un voisin existe
		if ($voisin) {
			// Update de l'exercice actuel avec l'ordre du voisin
			$this->db->table('exercice')->where('id', $idExercice)->update(['ordre' => $voisin['ordre']]);

			// Update du voisin avec l'ancien ordre de l'actuel
			$this->db->table('exercice')->where('id', $voisin['id'])->update(['ordre' => $ordreActuel]);
		}
	}
}