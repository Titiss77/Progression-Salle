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

    // Dans App/Controllers/Action.php

    public function creation($idSeance)
    {
        helper('form');

        // 1. Infos générales
        $infoSeance = $this->donneesModel->getSimpleSeance($idSeance);
        $idCategorie = $infoSeance['idCategorie'];

        // 2. Préparation des données pour la vue
        $data = [
            'cssPage' => 'creer.css',
            'titrePage' => 'Saisie de séance',
            'seance' => $infoSeance,
            'categorie' => $this->donneesModel->getUneCategorie($idCategorie),
            'exercices' => $this->donneesModel->getExercicesParCategorie($idCategorie),
            // AJOUT : On récupère ce qui a déjà été sauvegardé (si ça existe)
            'savedPerfs' => $this->donneesModel->getPerformancesRealisees($idSeance)
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
        $idSeance = $this->request->getPost('idSeance');
        $perfs = $this->request->getPost('perfs');
        $action = $this->request->getPost('action');  // On récupère 'sauvegarder' ou 'terminer'

        if (!$perfs || !is_array($perfs)) {
            return redirect()->back()->with('erreur', 'Aucune donnée reçue.');
        }

        // 1. Déterminer le statut selon le bouton cliqué
        $nouveauStatut = ($action === 'terminer') ? 'fini' : 'en_cours';

        // 2. Préparation des données
        $donneesAInserer = [];
        foreach ($perfs as $idExercice => $series) {
            foreach ($series as $numSerie => $valeurs) {
                // On accepte d'enregistrer même si reps est vide pour un brouillon (optionnel)
                // Mais gardons ton filtre !empty pour l'instant
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
            // A. IMPORTANT : On supprime les anciennes perfs de cette séance pour éviter les doublons
            $this->actionInDB->nettoyerPerformances($idSeance);

            // B. On insère les nouvelles données
            $this->actionInDB->ajouterPerformances($donneesAInserer);

            // C. On met à jour le statut de la séance (en_cours ou fini)
            $this->actionInDB->updateStatusSeance($idSeance, $nouveauStatut);

            // D. Redirection intelligente
            if ($nouveauStatut === 'en_cours') {
                // Si c'est une sauvegarde, on reste sur la page
                return redirect()
                    ->back()
                    ->with('succes', 'Brouillon sauvegardé. Vous pouvez continuer.');
            } else {
                // Si c'est terminé, on va à l'historique
                return redirect()
                    ->to('historique')
                    ->with('succes', 'Séance terminée et validée !');
            }
        } else {
            return redirect()->back()->with('erreur', 'Aucune performance saisie.');
        }
    }

    // AFFICHER LE FORMULAIRE D'AJOUT
    public function ajouterExercice($idCategorie)
    {
        helper('form');
        $data = [
            'cssPage' => 'modification.css',
            'titrePage' => 'Ajouter un exercice',
            'idCategorie' => $idCategorie,
            // Pas de variable 'exercice' car c'est une création
        ];
        return view('v_exercice_saisie', $data);
    }

    // AFFICHER LE FORMULAIRE DE MODIFICATION
    public function modifierExercice($idExercice)
    {
        helper('form');
        // On récupère les infos de l'exercice
        // (Il faudra ajouter cette fonction getUnExercice dans ton modèle Donnees)
        $exercice = $this->donneesModel->getUnExercice($idExercice);

        $data = [
            'cssPage' => 'modification.css',
            'titrePage' => "Modifier l'exercice",
            'idCategorie' => $exercice['idCategorie'],  // On le récupère pour le lien retour
            'exercice' => $exercice  // On passe les données pour pré-remplir
        ];
        return view('v_exercice_saisie', $data);
    }

    // SAUVEGARDER (INSERT OU UPDATE)
    public function sauvegarderExercice()
    {
        $id = $this->request->getPost('id');  // Vide si ajout, rempli si modif
        $idCategorie = $this->request->getPost('idCategorie');

        $data = [
            'id' => $id,  // Si l'ID est présent, CodeIgniter fera un UPDATE, sinon un INSERT
            'idCategorie' => $idCategorie,
            'libelle' => $this->request->getPost('libelle'),
            'nbSeries' => $this->request->getPost('nbSeries'),
            'charge' => $this->request->getPost('charge'),
        ];

        // On appelle le modèle d'écriture
        $this->actionInDB->saveExercice($data);

        return redirect()
            ->to('seance/modification/' . $idCategorie)
            ->with('succes', 'Exercice enregistré avec succès.');
    }

    // SUPPRIMER
    public function supprimerExercice($idExercice)
    {
        // 1. On récupère l'exercice avant de supprimer pour savoir où rediriger (quel idCategorie)
        $exercice = $this->donneesModel->getUnExercice($idExercice);
        $idCategorie = $exercice['idCategorie'];

        // 2. On supprime
        $this->actionInDB->deleteExercice($idExercice);

        return redirect()
            ->to('seance/modification/' . $idCategorie)
            ->with('succes', 'Exercice supprimé.');
    }

    public function monterExercice($idExercice)
    {
        $this->actionInDB->changerOrdre($idExercice, 'monter');

        // Redirection vers la liste (on doit retrouver l'ID Categorie)
        // Astuce : On le récupère vite fait ou on le stocke avant
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