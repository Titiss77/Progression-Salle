<?php

namespace App\Models;

use CodeIgniter\Model;

class ActionInDB extends Model
{
	protected $db;

	function __construct()
	{
		parent::__construct();
		$this->db = \Config\database::connect();
	}

	// ... (setSeanceVide, ajouterPerformances, etc. ne changent pas) ...
	public function setSeanceVide($idProgramme)
	{
		$data = [
			'idProgramme' => $idProgramme,
			'date_seance' => date('Y-m-d'),
		];
		$this->db->table('seances')->insert($data);
		return $this->db->insertID();
	}

	public function ajouterPerformances($data)
	{
		return $this->db->table('performances')->insertBatch($data);
	}

	public function updateStatusSeance($idSeance, $status)
	{
		return $this->db->table('seances')->where('id', $idSeance)->update(['status' => $status]);
	}

	public function nettoyerPerformances($idSeance)
	{
		return $this->db->table('performances')->where('idSeance', $idSeance)->delete();
	}

	public function deleteSeance($idSeance)
	{
		return $this->db->table('seances')->where('id', $idSeance)->delete();
	}

	// --- MODIFICATIONS POUR LA JOINTURE ---

	public function deleteExercice($id)
	{
		return $this->db->table('jointure')->where('idExercice', $id)->delete();
	}

	public function saveExercice($data)
	{
		// 1. Calcul du nouvel ordre (Basé sur la table JOINTURE pour ce programme)
		if (empty($data['id']) || !empty($data['idExistant'])) {
			$maxOrdre = $this
				->db
				->table('jointure')
				->where('idProgramme', $data['idProgramme'])
				->selectMax('ordre')
				->get()
				->getRowArray();

			$nouvelOrdre = ($maxOrdre['ordre'] ?? 0) + 1;
		}

		// CAS A : LIER UN EXISTANT
		if (empty($data['id']) && !empty($data['idExistant'])) {
			// Vérifier doublon
			$exists = $this
				->db
				->table('jointure')
				->where('idProgramme', $data['idProgramme'])
				->where('idExercice', $data['idExistant'])
				->countAllResults();

			if ($exists == 0) {
				$this->db->table('jointure')->insert([
					'idProgramme' => $data['idProgramme'],
					'idExercice' => $data['idExistant'],
					'ordre' => $nouvelOrdre  // <-- Ordre ici
				]);
			}
			return true;
		}

		// CAS B : CRÉER NOUVEAU
		if (empty($data['id'])) {
			$nouvelExercice = [
				'libelle' => $data['libelle'],
				'nbSeries' => $data['nbSeries'],
				'charge' => $data['charge'],
				'estActif' => 1
				// Pas d'ordre ici
			];

			$this->db->table('exercice')->insert($nouvelExercice);
			$idExerciceCree = $this->db->insertID();

			return $this->db->table('jointure')->insert([
				'idProgramme' => $data['idProgramme'],
				'idExercice' => $idExerciceCree,
				'ordre' => $nouvelOrdre  // <-- Ordre ici
			]);
		}
		// CAS C : MODIFICATION (Pas de changement d'ordre ici)
		else {
			return $this
				->db
				->table('exercice')
				->where('id', $data['id'])
				->update([
					'libelle' => $data['libelle'],
					'nbSeries' => $data['nbSeries'],
					'charge' => $data['charge'],
				]);
		}
	}

	/**
	 * Change l'ordre dans la table JOINTURE
	 */
	public function changerOrdre($idExercice, $idProgramme, $direction)
	{
		// 1. Récupérer l'entrée actuelle dans la jointure
		$lienActuel = $this
			->db
			->table('jointure')
			->where('idProgramme', $idProgramme)
			->where('idExercice', $idExercice)
			->get()
			->getRowArray();

		if (!$lienActuel)
			return;

		$ordreActuel = $lienActuel['ordre'];

		// 2. Trouver le voisin dans la MEME table jointure (même programme)
		$builder = $this
			->db
			->table('jointure')
			->where('idProgramme', $idProgramme);

		if ($direction === 'monter') {
			$voisin = $builder
				->where('ordre <', $ordreActuel)
				->orderBy('ordre', 'DESC')
				->limit(1)
				->get()
				->getRowArray();
		} else {
			$voisin = $builder
				->where('ordre >', $ordreActuel)
				->orderBy('ordre', 'ASC')
				->limit(1)
				->get()
				->getRowArray();
		}

		// 3. Echange des ordres
		if ($voisin) {
			// Update Voisin
			$this
				->db
				->table('jointure')
				->where('id', $voisin['id'])  // On utilise l'ID technique de la jointure c'est plus sûr
				->update(['ordre' => $ordreActuel]);

			// Update Actuel
			$this
				->db
				->table('jointure')
				->where('id', $lienActuel['id'])
				->update(['ordre' => $voisin['ordre']]);
		}
	}

	// ... (Gestion des programmes inchangée) ...
	public function deleteProgramme($id)
	{
		return $this->db->table('programme')->where('id', $id)->update(['estActif' => 0]);
	}

	public function saveProgramme($data)
	{
		if (empty($data['id'])) {
			$data['estActif'] = 1;
			return $this->db->table('programme')->insert($data);
		} else {
			return $this->db->table('programme')->where('id', $data['id'])->update(['libelle' => $data['libelle']]);
		}
	}

	public function supprimerLienExercice($idExercice, $idProgramme)
	{
		return $this
			->db
			->table('jointure')
			->where('idExercice', $idExercice)
			->where('idProgramme', $idProgramme)
			->delete();
	}
}
