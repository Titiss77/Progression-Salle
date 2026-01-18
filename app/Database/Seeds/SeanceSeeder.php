<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SeanceSeeder extends Seeder
{
    public function run()
    {
        // 1. Nettoyage de la table (Reset)
        $this->db->disableForeignKeyChecks();
        $this->db->table('seances')->truncate();
        $this->db->enableForeignKeyChecks();

        // 2. Récupérer les IDs des catégories existantes
        // Cela permet d'éviter les erreurs si vos ID sont 5, 6, 7 au lieu de 1, 2, 3
        $categories = $this->db->table('categorie')->select('id')->get()->getResultArray();
        
        // On transforme le résultat en un tableau simple d'IDs : [1, 2, 3, 4]
        $idsCategories = array_column($categories, 'id');

        if (empty($idsCategories)) {
            // Sécurité : Si aucune catégorie n'existe, on ne fait rien
            echo "Erreur : Aucune catégorie trouvée. Veuillez lancer ExerciceSeeder d'abord.\n";
            return;
        }

        // 3. Génération des données fictives
        $seances = [];

        // On va créer 10 séances sur les 10 derniers jours
        for ($i = 0; $i < 10; $i++) {
            // Choisir un ID de catégorie au hasard parmi ceux qui existent
            $randomKey = array_rand($idsCategories);
            $catId = $idsCategories[$randomKey];

            // Créer une date (Aujourd'hui moins $i jours)
            $date = date('Y-m-d', strtotime("-$i days"));

            $seances[] = [
                'idCategorie' => $catId,
                'date_seance' => $date,
            ];
        }

        // 4. Insertion en masse (plus performant que de faire 10 inserts)
        $this->db->table('seances')->insertBatch($seances);
    }
}