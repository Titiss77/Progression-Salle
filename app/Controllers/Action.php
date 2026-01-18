<?php

namespace App\Controllers;

use App\Models\Donnees;

class Action extends BaseController
{
    public function __construct()
    {
        $this->donneesModel = new Donnees();
    }

    public function choix($selection, $idCategorie)
    {
        if ($selection === 1) {
            $data = [
                'cssPage' => 'creer.css',
                'titrePage' => 'Creer une séance',
                'categories' => $this->donneesModel->getUneCategorie($idCategorie),
            ];
            return view('v_ceer', $data);
        } else {
            $data = [
                'cssPage' => 'creer.css',
                'titrePage' => 'Modifier',
                'categorie' => $this->donneesModel->getUneCategorie($idCategorie),
            ];
            return view('v_modifier', $data);
        }
    }
}