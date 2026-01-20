<?php

namespace App\Models;

use CodeIgniter\Model;

class Donnees extends Model
{
	protected $db;

	public function __construct()
	{
		parent::__construct();
		$this->db = \Config\Database::connect();
	}

	public function getUnProgramme($id)
	{
		return $this->db->table('programme')->where('id', $id)->get()->getRowArray();
	}

	public function getLesProgrammes()
	{
		return $this->db->table('programme')->where('estActif', 1)->get()->getResultArray();
	}

	public function getLesExercices()
	{
		return $this
			->db
			->table('exercice e')
			->select('e.id, j.idProgramme, e.libelle, e.charge, e.nbSeries')
			->join('jointure j', 'j.idExercice = e.id')
			->orderBy('ordre', 'ASC')
			->get()
			->getResultArray();
	}

	public function getTousLesExercices()
	{
		return $this
			->db
			->table('exercice')
			->select('id, libelle')
			->where('estActif', 1)
			->orderBy('libelle', 'ASC')
			->get()
			->getResultArray();
	}

	public function getExercicesParProgramme($idProgramme)
	{
		return $this
			->db
			->table('exercice e')
			->select('e.*, j.idProgramme, j.ordre')  // On sélectionne l'ordre de la jointure
			->join('jointure j', 'j.idExercice = e.id')
			->where('j.idProgramme', $idProgramme)
			->where('e.estActif', 1)
			->orderBy('j.ordre', 'ASC')  // TRI SUR JOINTURE
			->get()
			->getResultArray();
	}

	public function getUnExercice($id)
	{
		return $this
			->db
			->table('exercice e')
			->select('e.*, j.idProgramme')  // On a besoin de l'idProgramme
			->join('jointure j', 'j.idExercice = e.id', 'left')  // Left join au cas où
			->where('e.id', $id)
			->get()
			->getRowArray();
	}

	public function getLesSeances()
	{
		return $this
			->db
			->table('seances s')
			->select('s.id, c.libelle, s.date_seance, s.status')
			->join('programme c', 's.idProgramme = c.id')
			->orderBy('s.date_seance', 'DESC')
			->orderBy('s.id', 'DESC')
			->get()
			->getResultArray();
	}

	public function getUneSeances($id)
	{
		// Pour des requêtes complexes avec GROUP_CONCAT, le Query Builder est aussi possible
		// et rend la lecture des JOIN plus claire.
		return $this
			->db
			->table('performances p')
			->select('c.libelle AS titre, s.date_seance AS date, e.libelle')
			->select("GROUP_CONCAT(p.reps ORDER BY p.numero_serie ASC SEPARATOR ', ') as liste_reps")
			->select("GROUP_CONCAT(p.poids_effectif ORDER BY p.numero_serie ASC SEPARATOR ', ') as liste_poids")
			->join('exercice e', 'p.idExercice = e.id')
			->join('seances s', 's.id = p.idSeance')
			->join('programme c', 'c.id = s.idProgramme')
			->where('p.idSeance', $id)
			->groupBy('e.id, e.libelle')
			->orderBy('e.id', 'ASC')
			->get()
			->getResultArray();
	}

	public function getSimpleSeance($idSeance)
	{
		return $this->db->table('seances')->where('id', $idSeance)->get()->getRowArray();
	}

	public function getPerformancesRealisees($idSeance)
	{
		$query = $this->db->table('performances')->where('idSeance', $idSeance)->get()->getResultArray();
		$perfsOrdonnees = [];
		foreach ($query as $row) {
			$perfsOrdonnees[$row['idExercice']][$row['numero_serie']] = [
				'reps' => $row['reps'], 'poids' => $row['poids_effectif']
			];
		}
		return $perfsOrdonnees;
	}

	public function getStatistiques($id)
	{
		return $this
			->db
			->table('performances p')
			->select('c.libelle AS titre, s.date_seance AS date, e.libelle')
			// --- VOS ANCIENNES COLONNES (Listes) ---
			->select("GROUP_CONCAT(p.reps ORDER BY p.numero_serie ASC SEPARATOR ', ') as liste_reps")
			->select("GROUP_CONCAT(p.poids_effectif ORDER BY p.numero_serie ASC SEPARATOR ', ') as liste_poids")
			// --- NOUVELLES STATISTIQUES ---
			// 1. Nombre total de répétitions pour cet exercice
			->select('SUM(p.reps) as total_reps')
			// 2. Volume total (Tonnage) : La somme de (reps * poids) pour chaque série
			// Exemple : 3 séries de 10 reps à 100kg = 3000kg de volume
			->select('SUM(p.reps * p.poids_effectif) as volume_total')
			// 3. (Optionnel) Poids maximum soulevé sur une série (1RM estimé ou Max de la séance)
			->select('MAX(p.poids_effectif) as max_poids')
			// 4. (Optionnel) Nombre de séries
			->select('COUNT(p.numero_serie) as nb_series')
			->join('exercice e', 'p.idExercice = e.id')
			->join('seances s', 's.id = p.idSeance')
			->join('programme c', 'c.id = s.idProgramme')
			->where('p.idSeance', $id)
			->groupBy('e.id, e.libelle')  // On groupe toujours par exercice
			->orderBy('e.id', 'ASC')
			->get()
			->getResultArray();
	}
}
