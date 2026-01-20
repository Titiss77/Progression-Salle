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
		// 1. Calcul de l'ordre (nécessaire dans tous les cas d'ajout)
		if (empty($data['id'])) {
			// On récupère l'ordre max pour CE programme via la jointure
			$maxOrdre = $this
				->db
				->table('exercice e')
				->join('jointure j', 'j.idExercice = e.id')
				->where('j.idProgramme', $data['idProgramme'])
				->selectMax('e.ordre')
				->get()
				->getRowArray();

			$nouvelOrdre = ($maxOrdre['ordre'] ?? 0) + 1;
		}

		// CAS A : AJOUT D'UN EXERCICE EXISTANT (Sélectionné dans la liste)
		if (empty($data['id']) && !empty($data['idExistant'])) {
			// On vérifie si le lien existe déjà pour éviter les doublons
			$exists = $this
				->db
				->table('jointure')
				->where('idProgramme', $data['idProgramme'])
				->where('idExercice', $data['idExistant'])
				->countAllResults();

			if ($exists == 0) {
				// Création du lien dans la table jointure
				$this->db->table('jointure')->insert([
					'idProgramme' => $data['idProgramme'],
					'idExercice' => $data['idExistant']
				]);

				// Optionnel : On met à jour l'ordre de l'exercice global pour qu'il soit bien trié dans ce programme
				// (Note : Dans un système many-to-many strict, l'ordre devrait être dans la table jointure,
				// mais ici il est dans exercice, donc on le met à jour pour le dernier ajout).
				$this->db->table('exercice')->where('id', $data['idExistant'])->update(['ordre' => $nouvelOrdre]);
			}
			return true;
		}

		// CAS B : CRÉATION D'UN NOUVEL EXERCICE (Pas d'ID, pas d'Existant)
		if (empty($data['id'])) {
			$nouvelExercice = [
				'libelle' => $data['libelle'],
				'nbSeries' => $data['nbSeries'],
				'charge' => $data['charge'],
				'estActif' => 1,
				'ordre' => $nouvelOrdre
			];

			// 1. Insertion dans la table exercice
			$this->db->table('exercice')->insert($nouvelExercice);
			$idExerciceCree = $this->db->insertID();

			// 2. Insertion dans la table jointure
			return $this->db->table('jointure')->insert([
				'idProgramme' => $data['idProgramme'],
				'idExercice' => $idExerciceCree
			]);
		}
		// CAS C : MODIFICATION D'UN EXERCICE (L'ID existe déjà)
		else {
			$donneesUpdate = [
				'libelle' => $data['libelle'],
				'nbSeries' => $data['nbSeries'],
				'charge' => $data['charge'],
			];

			return $this
				->db
				->table('exercice')
				->where('id', $data['id'])
				->update($donneesUpdate);
		}
	}

	public function changerOrdre($idExercice, $direction)
	{
		// 1. Récupérer l'exercice et son Programme via la jointure
		$exercice = $this
			->db
			->table('exercice e')
			->select('e.*, j.idProgramme')
			->join('jointure j', 'j.idExercice = e.id')
			->where('e.id', $idExercice)
			->get()
			->getRowArray();

		if (!$exercice)
			return;

		$ordreActuel = $exercice['ordre'];
		$idProgramme = $exercice['idProgramme'];

		// 2. Trouver le voisin en filtrant via la jointure
		$builder = $this
			->db
			->table('exercice e')
			->select('e.*')
			->join('jointure j', 'j.idExercice = e.id')
			->where('j.idProgramme', $idProgramme)  // On reste dans le même programme
			->where('e.estActif', 1);

		if ($direction === 'monter') {
			$voisin = $builder
				->where('e.ordre <', $ordreActuel)
				->orderBy('e.ordre', 'DESC')
				->limit(1)
				->get()
				->getRowArray();
		} else {
			$voisin = $builder
				->where('e.ordre >', $ordreActuel)
				->orderBy('e.ordre', 'ASC')
				->limit(1)
				->get()
				->getRowArray();
		}

		// 3. Echange
		if ($voisin) {
			$this->db->table('exercice')->where('id', $idExercice)->update(['ordre' => $voisin['ordre']]);
			$this->db->table('exercice')->where('id', $voisin['id'])->update(['ordre' => $ordreActuel]);
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
        return $this->db->table('jointure')
            ->where('idExercice', $idExercice)
            ->where('idProgramme', $idProgramme)
            ->delete();
    }
}