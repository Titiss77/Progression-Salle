<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSeances extends Migration
{
    public function up()
    {
        // --- Table: seances ---
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'idCategorie' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            
            // CORRECTION : Suppression de 'auto_increment' qui causait l'erreur
            'date_seance' => ['type' => 'DATE', 'null' => false], 
        ]);
        
        $this->forge->addKey('id', true);
        
        // Clé étrangère vers la table 'categorie'
        $this->forge->addForeignKey('idCategorie', 'categorie', 'id', 'CASCADE', 'CASCADE');
        
        $this->forge->createTable('seances');
    }

    public function down()
    {
        $this->forge->dropTable('seances');
    }
}