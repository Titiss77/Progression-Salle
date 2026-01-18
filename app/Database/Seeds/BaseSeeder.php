<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BaseSeeder extends Seeder
{
    public function run()
    {
        $this->db->disableForeignKeyChecks();
        $this->db->table('exercice')->truncate();
        $this->db->table('categorie')->truncate();
        $this->db->enableForeignKeyChecks();

        $donnees = [
            'Pectoraux' => [
                ['libelle' => 'Développé couché', 'charge' => 80.5, 'nbSeries' => 4],
                ['libelle' => 'Écarté incliné', 'charge' => 22, 'nbSeries' => 3],
                ['libelle' => 'Pompes lestées', 'charge' => 10, 'nbSeries' => 4],
            ],
            'Dos' => [
                ['libelle' => 'Traction', 'charge' => 0, 'nbSeries' => 5],
                ['libelle' => 'Rowing barre', 'charge' => 60, 'nbSeries' => 4],
            ],
            'Jambes' => [
                ['libelle' => 'Squat', 'charge' => 100, 'nbSeries' => 5],
                ['libelle' => 'Presse à cuisses', 'charge' => 150, 'nbSeries' => 4],
                ['libelle' => 'Leg Extension', 'charge' => 45, 'nbSeries' => 3],
            ],
            'Cardio' => [
                ['libelle' => 'Tapis de course', 'charge' => null, 'nbSeries' => 1],
                ['libelle' => 'Vélo elliptique', 'charge' => null, 'nbSeries' => 1],
            ]
        ];

        foreach ($donnees as $nomCategorie => $exercices) {
            $this->db->table('categorie')->insert([
                'libelle' => $nomCategorie,
            ]);

            $idCategorie = $this->db->insertID();

            foreach ($exercices as $exo) {
                $dataExercice = [
                    'idCategorie' => $idCategorie,
                    'libelle'     => $exo['libelle'],
                    'charge'      => $exo['charge'],
                    'nbSeries'    => $exo['nbSeries'],
                ];
                
                $this->db->table('exercice')->insert($dataExercice);
            }
        }
    }
}