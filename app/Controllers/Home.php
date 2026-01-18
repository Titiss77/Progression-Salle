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
            'titrePage' => 'Accueil',
        ];

        return view('v_accueil', $data);
    }

    public function seances()
    {
        $data = [
            'cssPage' => 'seances.css',
            'titrePage' => 'Séances',
            'categories' => $this->donneesModel->getLesCategories(),
            'exercices' => $this->donneesModel->getLesExercices(),
        ];

        return view('v_seances', $data);
    }

    public function historique()
    {
        $data = [
            'cssPage' => 'historique.css',
            'titrePage' => 'Historique',
            'seances' => $this->donneesModel->getLesSeances(),
        ];

        return view('v_historique', $data);
    }

    public function detail($id)
    {
        // 1. On récupère les données UNE SEULE FOIS
        $seance = $this->donneesModel->getUneSeances($id);

        // 2. Sécurité : On vérifie si la séance existe
        if (empty($seance)) {
            return redirect()->to('/historique')->with('erreur', 'Séance introuvable.');
        }

        // 3. On prépare les données pour la vue
        $data = [
            'cssPage' => 'uneSeance.css',
            'titrePage' => $seance[0]['titre'].' : '.$seance[0]['date'],
            'seance' => $seance,
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
                'cssPage' => 'choix.css',
                'titrePage' => $action . ' une séance',
                'texte' => $action,
                'selection' => $selection,
                'categories' => $this->donneesModel->getLesCategories(),
            ];

            return view('v_choix', $data);
        }
    }
}