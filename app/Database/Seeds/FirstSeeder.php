<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FirstSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'debut'         => '1ere migration',
        ];
        $this->db->table('first')->insert($data);
    }
}