<?php

namespace App\Controllers;

use App\Models\ActionInDB;
use App\Models\Donnees;

class Action extends BaseController
{
    public function __construct()
    {
        $this->donneesModel = new Donnees();
        $this->actionInDB = new ActionInDB();
    }

    public function choix($selection, $idCategorie)
    {
        if ($selection == '1') {
            $newId = $this->actionInDB->setSeanceVide($idCategorie);

            if ($newId) {
                return redirect()
                    ->to('seance/creation/' . $newId)
                    ->with('succes', 'Séance créée avec succès.');
            } else {
                return redirect()
                    ->back()
                    ->with('erreur', 'Impossible de créer la séance.');
            }
        } else {
            return redirect()->to('seance/modification/' . $idCategorie);
        }
    }

    public function creation($idSeance)
    {
        helper('form');

        $infoSeance = $this->donneesModel->getSimpleSeance($idSeance);
        $idCategorie = $infoSeance['idCategorie'];

        $data = [
            'cssPage' => 'creer.css',
            'titrePage' => 'Saisie de séance',
            'seance' => $infoSeance,
            'categorie' => $this->donneesModel->getUneCategorie($idCategorie),
            'exercices' => $this->donneesModel->getExercicesParCategorie($idCategorie),
            'savedPerfs' => $this->donneesModel->getPerformancesRealisees($idSeance)
        ];

        return view('v_creer', $data);
    }

    public function modification($idCategorie)
    {
        $data = [
            'cssPage' => 'modification.css',
            'titrePage' => 'Modifier le modèle',
            'categorie' => $this->donneesModel->getUneCategorie($idCategorie),
            'exercices' => $this->donneesModel->getExercicesParCategorie($idCategorie),
        ];

        return view('v_modifier', $data);
    }

    public function enregistrer()
    {
        $idSeance = $this->request->getPost('idSeance');
        $perfs = $this->request->getPost('perfs');
        $action = $this->request->getPost('action');

        if (!$perfs || !is_array($perfs)) {
            return redirect()->back()->with('erreur', 'Aucune donnée reçue.');
        }

        $nouveauStatut = ($action === 'terminer') ? 'fini' : 'en_cours';

        $donneesAInserer = [];
        foreach ($perfs as $idExercice => $series) {
            foreach ($series as $numSerie => $valeurs) {
                if (!empty($valeurs['reps'])) {
                    $donneesAInserer[] = [
                        'idSeance' => $idSeance,
                        'idExercice' => $idExercice,
                        'numero_serie' => $numSerie,
                        'reps' => $valeurs['reps'],
                        'poids_effectif' => $valeurs['poids']
                    ];
                }
            }
        }

        if (!empty($donneesAInserer)) {
            $this->actionInDB->nettoyerPerformances($idSeance);

            $this->actionInDB->ajouterPerformances($donneesAInserer);

            $this->actionInDB->updateStatusSeance($idSeance, $nouveauStatut);

            if ($nouveauStatut === 'en_cours') {
                return redirect()
                    ->back()
                    ->with('succes', 'Brouillon sauvegardé. Vous pouvez continuer.');
            } else {
                return redirect()
                    ->to('historique')
                    ->with('succes', 'Séance terminée et validée !');
            }
        } else {
            return redirect()->back()->with('erreur', 'Aucune performance saisie.');
        }
    }

    public function ajouterExercice($idCategorie)
    {
        helper('form');
        $data = [
            'cssPage' => 'modification.css',
            'titrePage' => 'Ajouter un exercice',
            'idCategorie' => $idCategorie,
        ];
        return view('v_exercice_saisie', $data);
    }

    public function modifierExercice($idExercice)
    {
        helper('form');
        $exercice = $this->donneesModel->getUnExercice($idExercice);

        $data = [
            'cssPage' => 'modification.css',
            'titrePage' => "Modifier l'exercice",
            'idCategorie' => $exercice['idCategorie'],
            'exercice' => $exercice
        ];
        return view('v_exercice_saisie', $data);
    }

    public function sauvegarderExercice()
    {
        $id = $this->request->getPost('id');
        $idCategorie = $this->request->getPost('idCategorie');

        $data = [
            'id' => $id,
            'idCategorie' => $idCategorie,
            'libelle' => $this->request->getPost('libelle'),
            'nbSeries' => $this->request->getPost('nbSeries'),
            'charge' => $this->request->getPost('charge'),
        ];

        $this->actionInDB->saveExercice($data);

        return redirect()
            ->to('seance/modification/' . $idCategorie)
            ->with('succes', 'Exercice enregistré avec succès.');
    }

    public function supprimerExercice($idExercice)
    {
        $exercice = $this->donneesModel->getUnExercice($idExercice);
        $idCategorie = $exercice['idCategorie'];

        $this->actionInDB->deleteExercice($idExercice);

        return redirect()
            ->to('seance/modification/' . $idCategorie)
            ->with('succes', 'Exercice supprimé.');
    }

    public function monterExercice($idExercice)
    {
        $this->actionInDB->changerOrdre($idExercice, 'monter');

        $ex = $this->donneesModel->getUnExercice($idExercice);
        return redirect()->to('seance/modification/' . $ex['idCategorie']);
    }

    public function descendreExercice($idExercice)
    {
        $this->actionInDB->changerOrdre($idExercice, 'descendre');

        $ex = $this->donneesModel->getUnExercice($idExercice);
        return redirect()->to('seance/modification/' . $ex['idCategorie']);
    }
}