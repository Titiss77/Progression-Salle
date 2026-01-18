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

	public function setSeanceVide($idCategorie)
	{
		$data = [
			'idCategorie' => $idCategorie,
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
		return $this
			->db
			->table('seances')
			->where('id', $idSeance)
			->update(['status' => $status]);
	}

	public function nettoyerPerformances($idSeance)
	{
		return $this->db->table('performances')->where('idSeance', $idSeance)->delete();
	}

	public function deleteExercice($id)
	{
		return $this
			->db
			->table('exercice')
			->where('id', $id)
			->update(['estActif' => 0]);
	}

	public function saveExercice($data)
	{
		if (empty($data['id'])) {
			unset($data['id']);
			$data['estActif'] = 1;

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
		} else {
			$oldExo = $this->db->table('exercice')->where('id', $data['id'])->get()->getRowArray();

			$this
				->db
				->table('exercice')
				->where('id', $data['id'])
				->update(['estActif' => 0]);

			$nouvelExercice = [
				'idCategorie' => $data['idCategorie'],
				'libelle' => $data['libelle'],
				'nbSeries' => $data['nbSeries'],
				'charge' => $data['charge'],
				'estActif' => 1,
				'ordre' => $oldExo['ordre']
			];

			return $this->db->table('exercice')->insert($nouvelExercice);
		}
	}

	public function changerOrdre($idExercice, $direction)
	{
		$exercice = $this->db->table('exercice')->where('id', $idExercice)->get()->getRowArray();

		if (!$exercice)
			return;

		$ordreActuel = $exercice['ordre'];
		$idCategorie = $exercice['idCategorie'];

		$builder = $this
			->db
			->table('exercice')
			->where('idCategorie', $idCategorie)
			->where('estActif', 1);

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

		if ($voisin) {
			$this->db->table('exercice')->where('id', $idExercice)->update(['ordre' => $voisin['ordre']]);

			$this->db->table('exercice')->where('id', $voisin['id'])->update(['ordre' => $ordreActuel]);
		}
	}
}