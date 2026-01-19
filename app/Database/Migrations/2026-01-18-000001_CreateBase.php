<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBase extends Migration
{
    public function up()
    {
        // --- Table: programme ---
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'libelle'     => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => false],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('programme');

        // --- Table: exercice ---
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'idProgramme' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'libelle'     => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => false],
            'charge'      => ['type' => 'FLOAT', 'constraint' => 10, 'null' => true],
            'nbSeries'    => ['type' => 'INT', 'constraint' => 2, 'null' => true],
            'estActif'    => ['type'=> 'INT', 'constraint' => 1, 'default' => 1],
            'ordre'       => ['type'=> 'INT', 'constraint' => 20, 'default' => 1],
        ]);
        
        $this->forge->addKey('id', true);
        
        // This will now work because types match
        $this->forge->addForeignKey('idProgramme', 'programme', 'id', 'CASCADE', 'CASCADE');
        
        $this->forge->createTable('exercice');
    }

    public function down()
    {
        // Drop child table first to avoid constraint errors
        $this->forge->dropTable('exercice');
        $this->forge->dropTable('programme');
    }
}