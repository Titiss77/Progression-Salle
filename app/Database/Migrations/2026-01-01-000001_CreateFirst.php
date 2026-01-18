<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFirst extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'debut'         => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('first');
    }

    public function down()
    {
        $this->forge->dropTable('first');
    }
}