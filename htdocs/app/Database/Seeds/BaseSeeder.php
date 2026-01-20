<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Désactiver les vérifications de clés étrangères pour vider les tables proprement
        $this->db->disableForeignKeyChecks();
        $this->db->table('jointure')->truncate();  // Table enfant (liaison)
        $this->db->table('exercice')->truncate();
        $this->db->table('programme')->truncate();
        $this->db->enableForeignKeyChecks();

        // Données initiales
        $donnees = [
            'Upper' => [
                ['libelle' => 'Développé couché', 'charge' => 65, 'nbSeries' => 3, 'ordre' => '1'],
                ['libelle' => 'Tirage vertical', 'charge' => 65, 'nbSeries' => 3, 'ordre' => '2'],
                ['libelle' => 'Développé incliné', 'charge' => 42.5, 'nbSeries' => 3, 'ordre' => '3'],
                ['libelle' => 'Extensions lombaires', 'charge' => 32.5, 'nbSeries' => 3, 'ordre' => '4'],
                ['libelle' => 'Elévations frontales', 'charge' => 12, 'nbSeries' => 3, 'ordre' => '5'],
                ['libelle' => 'Développé militaire', 'charge' => 12, 'nbSeries' => 3, 'ordre' => '6'],
                ['libelle' => 'Elévations penchées', 'charge' => 10, 'nbSeries' => 3, 'ordre' => '7'],
                ['libelle' => 'Extensions bras droits', 'charge' => 27.5, 'nbSeries' => 3, 'ordre' => '8'],
                ['libelle' => 'Curls biceps assis', 'charge' => 12, 'nbSeries' => 3, 'ordre' => '9'],
                ['libelle' => 'Curls marteau assis', 'charge' => 14, 'nbSeries' => 3, 'ordre' => '10'],
                ['libelle' => 'Extensions triceps bas', 'charge' => 22.5, 'nbSeries' => 3, 'ordre' => '11'],
                ['libelle' => 'Extensions triceps haut', 'charge' => 17.5, 'nbSeries' => 3, 'ordre' => '12'],
            ],
            'Lower' => [
                ['libelle' => 'Squats à la barre', 'charge' => 65, 'nbSeries' => 3, 'ordre' => '1'],
                ['libelle' => 'Leg extensions', 'charge' => 60, 'nbSeries' => 3, 'ordre' => '2'],
                ['libelle' => 'RDL', 'charge' => 67.5, 'nbSeries' => 3, 'ordre' => '3'],
                ['libelle' => 'Extensions mollets', 'charge' => 130, 'nbSeries' => 3, 'ordre' => '4'],
            ]
        ];

        foreach ($donnees as $nomProgramme => $exercices) {
            // 2. Création du programme
            $this->db->table('programme')->insert([
                'libelle' => $nomProgramme,
                'estActif' => 1
            ]);
            $idProgramme = $this->db->insertID();

            foreach ($exercices as $exo) {
                // 3. Vérifier si l'exercice existe déjà (par libellé)
                $existingExo = $this
                    ->db
                    ->table('exercice')
                    ->where('libelle', $exo['libelle'])
                    ->get()
                    ->getRowArray();

                if ($existingExo) {
                    // S'il existe, on récupère son ID
                    $idExercice = $existingExo['id'];
                } else {
                    // Sinon, on le crée
                    $dataExercice = [
                        'libelle' => $exo['libelle'],
                        'charge' => $exo['charge'],
                        'nbSeries' => $exo['nbSeries'],
                        'ordre' => $exo['ordre'],
                        'estActif' => 1
                    ];
                    $this->db->table('exercice')->insert($dataExercice);
                    $idExercice = $this->db->insertID();
                }

                // 4. Créer le lien dans la table de jointure
                $this->db->table('jointure')->insert([
                    'idProgramme' => $idProgramme,
                    'idExercice' => $idExercice
                ]);
            }
        }
    }
}
