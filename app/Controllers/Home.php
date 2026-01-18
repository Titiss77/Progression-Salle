<?php

namespace App\Controllers;

use App\Models\Donnees;

class Home extends BaseController
{
    public function __construct()
    {
        $this->donneesModel = new Donnees();
    }

    public function index()
    {
        $data = [
            'cssPage' => 'accueil.css',
            'titrePage' => 'accueil',
        ];

        return view('v_accueil', $data);
    }

    public function seances()
    {
        $data = [
            'cssPage' => 'seances.css',
            'titrePage' => 'geseances',
            'categories' => $this->donneesModel->getLesCategories(),
            'exercices' => $this->donneesModel->getLesExercices(),
        ];

        return view('v_seances', $data);
    }

    public function historique()
    {
        $data = [
            'cssPage' => 'historique.css',
            'titrePage' => 'historique',
            'seances' => $this->donneesModel->getLesSeances(),
        ];

        return view('v_historique', $data);
    }

    public function detail($id)
    {
        $data = [
            'cssPage' => 'uneSeance.css',
            'titrePage' => 'Nop',
            'seance' => $this->donneesModel->getUneSeances($id),
        ];

        return view('v_seance_detail', $data);
    }

    public function choix($selection, $idCategorie = null)
    {
        if ($selection == 1) {
            $action = 'Créer';
        } else {
            $action = 'Modifier';
        }

        if ($idCategorie === null) {
            $data = [
                'cssPage' => 'Choix.css',
                'titrePage' => $action . ' une séance',
                'texte' => $action,
                'selection' => $selection,
                'categories' => $this->donneesModel->getLesCategories(),
            ];

            return view('v_choix', $data);
        }
    }
}