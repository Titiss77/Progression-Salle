<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePerformances extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'idSeance' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'idExercice' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'numero_serie' => [
                'type'       => 'INT',
                'constraint' => 3, // Ex: Série 1, Série 2...
            ],
            'reps' => [
                'type'       => 'INT',
                'constraint' => 5, // Ex: 12 répétitions
            ],
            'poids_effectif' => [
                'type'       => 'FLOAT', // Le poids peut changer d'une série à l'autre
                'null'       => true,
            ],
        ]);

        $this->forge->addKey('id', true);

        // Clés étrangères
        $this->forge->addForeignKey('idSeance', 'seances', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('idExercice', 'exercice', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('performances');
    }

    public function down()
    {
        $this->forge->dropTable('performances');
    }
}