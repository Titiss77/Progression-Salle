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
            'Upper' => [
                ['libelle' => 'Développé couché', 'charge' => 65, 'nbSeries' => 3],
                ['libelle' => 'Tirage vertical', 'charge' => 65, 'nbSeries' => 3],
                ['libelle' => 'Développé incliné', 'charge' => 42.5, 'nbSeries' => 3],
                ['libelle' => 'Extensions lombaires', 'charge' => 32.5, 'nbSeries' => 3],
                ['libelle' => 'Elévations frontales', 'charge' => 12, 'nbSeries' => 3],
                ['libelle' => 'Développé militaire', 'charge' => 12, 'nbSeries' => 3],
                ['libelle' => 'Elévations penchées', 'charge' => 10, 'nbSeries' => 3],
                ['libelle' => 'Extensions bras droits', 'charge' => 27.5, 'nbSeries' => 3],
                ['libelle' => 'Curls biceps assis', 'charge' => 12, 'nbSeries' => 4],
                ['libelle' => 'Curls marteau assis', 'charge' => 14, 'nbSeries' => 4],
                ['libelle' => 'Extensions triceps bas', 'charge' => 22.5, 'nbSeries' => 4],
                ['libelle' => 'Extensions triceps haut', 'charge' => 17.5, 'nbSeries' => 4],
            ],
            'Lower' => [
                ['libelle' => 'Squats à la barre', 'charge' => 65, 'nbSeries' => 4],
                ['libelle' => 'Leg extensions', 'charge' => 60, 'nbSeries' => 4],
                ['libelle' => 'RDL', 'charge' => 67.5, 'nbSeries' => 4],
                ['libelle' => 'Extensions mollets', 'charge' => 130, 'nbSeries' => 4],
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