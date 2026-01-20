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
        // Données propres à l'exercice
        $dataExercice = [
            'libelle'  => $data['libelle'],
            'nbSeries' => $data['nbSeries'],
            'charge'   => $data['charge'],
            'estActif' => 1
        ];

        if (empty($data['id'])) {
            // --- INSERTION (NOUVEAU) ---
            
            // 1. Calcul de l'ordre (via la jointure pour compter les exos de ce programme)
            $maxOrdre = $this->db->table('exercice e')
                ->join('jointure j', 'j.idExercice = e.id')
                ->where('j.idProgramme', $data['idProgramme'])
                ->where('e.estActif', 1)
                ->selectMax('e.ordre')
                ->get()
                ->getRowArray();

            $dataExercice['ordre'] = ($maxOrdre['ordre'] ?? 0) + 1;

            // 2. Création de l'exercice
            $this->db->table('exercice')->insert($dataExercice);
            $idExercice = $this->db->insertID();

            // 3. Création du lien dans la table JOINTURE
            return $this->db->table('jointure')->insert([
                'idProgramme' => $data['idProgramme'],
                'idExercice'  => $idExercice
            ]);

        } else {
            // --- MISE A JOUR ---
            // On met à jour l'exercice. Le lien jointure existe déjà, pas besoin d'y toucher.
            return $this->db->table('exercice')
                ->where('id', $data['id'])
                ->update($dataExercice);
        }
    }

    public function changerOrdre($idExercice, $direction)
    {
        // 1. Récupérer l'exercice et son Programme via la jointure
        $exercice = $this->db->table('exercice e')
            ->select('e.*, j.idProgramme')
            ->join('jointure j', 'j.idExercice = e.id')
            ->where('e.id', $idExercice)
            ->get()
            ->getRowArray();

        if (!$exercice) return;

        $ordreActuel = $exercice['ordre'];
        $idProgramme = $exercice['idProgramme'];

        // 2. Trouver le voisin en filtrant via la jointure
        $builder = $this->db->table('exercice e')
            ->select('e.*')
            ->join('jointure j', 'j.idExercice = e.id')
            ->where('j.idProgramme', $idProgramme) // On reste dans le même programme
            ->where('e.estActif', 1);

        if ($direction === 'monter') {
            $voisin = $builder->where('e.ordre <', $ordreActuel)
                ->orderBy('e.ordre', 'DESC')->limit(1)->get()->getRowArray();
        } else {
            $voisin = $builder->where('e.ordre >', $ordreActuel)
                ->orderBy('e.ordre', 'ASC')->limit(1)->get()->getRowArray();
        }

        // 3. Echange
        if ($voisin) {
            $this->db->table('exercice')->where('id', $idExercice)->update(['ordre' => $voisin['ordre']]);
            $this->db->table('exercice')->where('id', $voisin['id'])->update(['ordre' => $ordreActuel]);
        }
    }

    // ... (Gestion des programmes inchangée) ...
    public function deleteProgramme($id) {
        return $this->db->table('programme')->where('id', $id)->update(['estActif' => 0]);
    }

    public function saveProgramme($data) {
        if (empty($data['id'])) {
            $data['estActif'] = 1;
            return $this->db->table('programme')->insert($data);
        } else {
            return $this->db->table('programme')->where('id', $data['id'])->update(['libelle' => $data['libelle']]);
        }
    }
}