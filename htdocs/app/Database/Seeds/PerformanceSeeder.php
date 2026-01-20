<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PerformanceSeeder extends Seeder
{
    public function run()
    {
        // 1. Nettoyage
        $this->db->disableForeignKeyChecks();
        $this->db->table('performances')->truncate();
        $this->db->enableForeignKeyChecks();

        // 2. Récupérer toutes les séances existantes
        $seances = $this->db->table('seances')->get()->getResultArray();

        $dataToInsert = [];

        foreach ($seances as $seance) {
            // Pour chaque séance, on récupère les exercices de la catégorie concernée
            $exercices = $this->db->table('exercice')
                ->where('idProgramme', $seance['idProgramme'])
                ->get()
                ->getResultArray();

            foreach ($exercices as $exo) {
                // On récupère le nombre de séries prévu pour cet exercice (ex: 4)
                $nbSeries = $exo['nbSeries'] ?? 3; // 3 par défaut si null
                $chargeBase = $exo['charge'];

                // Pour chaque série (1, 2, 3, 4...)
                for ($i = 1; $i <= $nbSeries; $i++) {
                    
                    // Simulation un peu réaliste : 
                    // Séries 1 et 2 : on fait 12 reps
                    // Séries 3 et 4 : on fatigue, on fait 10 ou 8 reps
                    $reps = rand(8, 12);
                    if ($i > 2) $reps = rand(6, 10);

                    $dataToInsert[] = [
                        'idSeance'       => $seance['id'],
                        'idExercice'     => $exo['id'],
                        'numero_serie'   => $i,
                        'reps'           => $reps,
                        'poids_effectif' => $chargeBase, // On utilise la charge par défaut
                    ];
                }
            }
        }

        // 3. Insertion par lots (Batch) pour la performance
        // On découpe par paquets de 1000 pour ne pas saturer la mémoire si beaucoup de données
        if (!empty($dataToInsert)) {
            $chunks = array_chunk($dataToInsert, 1000);
            foreach ($chunks as $chunk) {
                $this->db->table('performances')->insertBatch($chunk);
            }
        }
    }
}