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
            // CORRECTION ICI : On passe par la table 'jointure' pour trouver les exercices du programme
            $exercices = $this->db->table('exercice')
                ->select('exercice.*') // On sélectionne les infos de l'exercice
                ->join('jointure', 'jointure.idExercice = exercice.id') // On joint la table de liaison
                ->where('jointure.idProgramme', $seance['idProgramme']) // On filtre sur le programme de la séance
                ->get()
                ->getResultArray();

            foreach ($exercices as $exo) {
                // On récupère le nombre de séries prévu pour cet exercice (ex: 4)
                $nbSeries = $exo['nbSeries'] ?? 3;
                $chargeBase = $exo['charge'];

                // Pour chaque série (1, 2, 3, 4...)
                for ($i = 1; $i <= $nbSeries; $i++) {
                    
                    // Simulation : Séries 1 et 2 (12 reps), Séries 3+ (Fatigue, 6-10 reps)
                    $reps = rand(8, 12);
                    if ($i > 2) $reps = rand(6, 10);

                    $dataToInsert[] = [
                        'idSeance'       => $seance['id'],
                        'idExercice'     => $exo['id'],
                        'numero_serie'   => $i,
                        'reps'           => $reps,
                        'poids_effectif' => $chargeBase,
                    ];
                }
            }
        }

        // 3. Insertion par lots (Batch)
        if (!empty($dataToInsert)) {
            $chunks = array_chunk($dataToInsert, 1000);
            foreach ($chunks as $chunk) {
                $this->db->table('performances')->insertBatch($chunk);
            }
        }
    }
}