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
            'titrePage' => 'Accueil',
        ];

        return view('v_accueil', $data);
    }

    public function seances()
    {
        $data = [
            'titrePage' => 'Séances',
            'programmes' => $this->donneesModel->getLesProgrammes(),
            'exercices' => $this->donneesModel->getLesExercices(),
        ];

        return view('v_seances', $data);
    }

    public function historique()
    {
        $data = [
            'titrePage' => 'Historique',
            'seances' => $this->donneesModel->getLesSeances(),
        ];

        return view('v_historique', $data);
    }

    public function detail($id)
    {
        $seance = $this->donneesModel->getUneSeances($id);

        if (empty($seance)) {
            return redirect()->to('/historique')->with('erreur', 'Séance introuvable.');
        }

        $data = [
            'titrePage' => $seance[0]['titre'] . ' : ' . $seance[0]['date'],
            'seance' => $seance,
        ];

        return view('v_seance_detail', $data);
    }

    public function choix($selection, $idProgramme = null)
    {
        if ($selection == 1) {
            $action = 'Créer';
        } else {
            $action = 'Modifier';
        }

        if ($idProgramme === null) {
            $data = [
                'titrePage' => $action . ' une séance',
                'texte' => $action,
                'selection' => $selection,
                'programmes' => $this->donneesModel->getLesProgrammes(),
            ];

            return view('v_choix', $data);
        }
    }
}