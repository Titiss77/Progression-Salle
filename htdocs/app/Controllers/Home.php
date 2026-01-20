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
        // 1. On utilise getStatistiques car elle contient TOUT (Infos séance + Calculs)
        $donnees_completes = $this->donneesModel->getStatistiques($id);

        // 2. Vérification si la séance existe
        if (empty($donnees_completes)) {
            return redirect()->to('/historique')->with('erreur', 'Séance introuvable.');
        }

        $data = [
            // On récupère le titre et la date depuis la première ligne des résultats
            'titrePage' => $donnees_completes[0]['titre'] . ' : ' . date('d/m/Y', strtotime($donnees_completes[0]['date'])),
            // 3. IMPORTANT : On passe le tableau complet à la clé 'seance'
            // pour que la Vue puisse faire "foreach ($seance as $exo)"
            'seance' => $donnees_completes,
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
