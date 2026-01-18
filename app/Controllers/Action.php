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
        // CAS 1 : CRÉATION (Nouvelle séance)
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
        }
        // CAS 2 : MODIFICATION DU MODÈLE (On passe l'ID de la catégorie)
        else {
            return redirect()->to('seance/modification/' . $idCategorie);
        }
    }

    public function creation($idSeance)
    {
        helper('form');
        // 1. On récupère les infos de la séance (ID Categorie, Date...)
        // ATTENTION : Il faut une méthode légère dans le modèle pour ça (voir plus bas)
        $infoSeance = $this->donneesModel->getSimpleSeance($idSeance);

        // 2. On extrait l'ID de la catégorie
        $idCategorie = $infoSeance['idCategorie'];

        $data = [
            'cssPage' => 'creer.css',
            'titrePage' => 'Nouvelle Séance',
            // On récupère les infos de la catégorie
            'categorie' => $this->donneesModel->getUneCategorie($idCategorie),
            // On récupère la liste des exercices prévus pour cette catégorie
            'exercices' => $this->donneesModel->getExercicesParCategorie($idCategorie),
            // On passe aussi l'info de la séance (pour avoir la date ou l'ID pour les formulaires)
            'seance' => $infoSeance
        ];

        return view('v_creer', $data);
    }

    // Ici on reçoit l'ID Categorie car c'est le modèle qu'on modifie
    public function modification($idCategorie)
    {
        $data = [
            'cssPage' => 'modification.css',
            'titrePage' => 'Modifier le modèle',
            // On récupère les mêmes infos pour pouvoir afficher la liste à modifier
            'categorie' => $this->donneesModel->getUneCategorie($idCategorie),
            'exercices' => $this->donneesModel->getExercicesParCategorie($idCategorie),
        ];

        return view('v_modifier', $data);
    }

    public function enregistrer()
    {
        // 1. Récupération des données brutes du formulaire
        $idSeance = $this->request->getPost('idSeance');
        $perfs = $this->request->getPost('perfs');  // C'est notre grand tableau

        // Si le formulaire est vide (protection)
        if (!$perfs || !is_array($perfs)) {
            return redirect()->back()->with('erreur', 'Aucune donnée reçue.');
        }

        $donneesAInserer = [];

        // 2. Traitement des boucles imbriquées
        // Boucle 1 : On parcourt chaque Exercice (ID 5, ID 8...)
        foreach ($perfs as $idExercice => $series) {
            // Boucle 2 : On parcourt chaque Série (1, 2, 3...)
            foreach ($series as $numSerie => $valeurs) {
                // On vérifie que l'utilisateur a bien rentré des répétitions
                // (Si le champ reps est vide, on n'enregistre pas cette ligne)
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

        // 3. Appel au modèle pour tout insérer d'un coup
        if (!empty($donneesAInserer)) {
            $this->actionInDB->ajouterPerformances($donneesAInserer);

            // SUCCÈS : On redirige vers l'historique ou le récap
            return redirect()
                ->to('historique')
                ->with('succes', 'Séance enregistrée avec succès !');
        } else {
            return redirect()->back()->with('erreur', 'Aucune performance saisie.');
        }
    }
}