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

        $seances = [
                ['idCategorie' => 1, 'date_seance' => '2026-01-17', 'status' => 'fini'],
                ['idCategorie' => 2, 'date_seance' => '2026-01-15', 'status' => 'fini'],
            ];
            
        $this->db->table('seances')->insertBatch($seances);
    }
}