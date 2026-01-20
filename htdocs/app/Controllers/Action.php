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

    public function choix($selection, $idProgramme)
    {
        if ($selection == '1') {
            $newId = $this->actionInDB->setSeanceVide($idProgramme);

            if ($newId) {
                return redirect()->to('seance/creation/' . $newId)->with('succes', 'Séance créée avec succès.');
            } else {
                return redirect()->back()->with('erreur', 'Impossible de créer la séance.');
            }
        } else {
            return redirect()->to('seance/modification/' . $idProgramme);
        }
    }

    public function creation($idSeance)
    {
        helper('form');

        $infoSeance = $this->donneesModel->getSimpleSeance($idSeance);
        $idProgramme = $infoSeance['idProgramme'];

        $data = [
            'titrePage' => 'Saisie de séance',
            'seance' => $infoSeance,
            'programme' => $this->donneesModel->getUnProgramme($idProgramme),
            'exercices' => $this->donneesModel->getExercicesParProgramme($idProgramme),
            'savedPerfs' => $this->donneesModel->getPerformancesRealisees($idSeance)
        ];

        return view('v_creer', $data);
    }

    public function modification($idProgramme)
    {
        $data = [
            'titrePage' => 'Modifier le modèle',
            'programme' => $this->donneesModel->getUnProgramme($idProgramme),
            // Utilise désormais la jointure via le Modèle
            'exercices' => $this->donneesModel->getExercicesParProgramme($idProgramme),
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
                return redirect()->back()->with('succes', 'Brouillon sauvegardé.');
            } else {
                return redirect()->to('historique')->with('succes', 'Séance terminée !');
            }
        } else {
            return redirect()->back()->with('erreur', 'Aucune performance saisie.');
        }
    }

    public function ajouterExercice($idProgramme)
    {
        helper('form');
        $data = [
            'titrePage' => 'Ajouter un exercice',
            'idProgramme' => $idProgramme,
            // AJOUT : On passe la liste des exercices existants
            'listeExercices' => $this->donneesModel->getTousLesExercices(),
        ];
        return view('v_exercice_saisie', $data);
    }

    public function modifierExercice($idExercice, $idProgramme)
    {
        helper('form');

        // On récupère les infos de l'exercice
        $exercice = $this->donneesModel->getUnExercice($idExercice);

        $data = [
            'titrePage' => "Modifier l'exercice",
            // IMPORTANT : On utilise l'ID passé dans l'URL, pas celui de la base de données
            'idProgramme' => $idProgramme,
            'exercice' => $exercice,
            // On garde la liste pour éviter les erreurs, même si pas utilisée en modif
            'listeExercices' => $this->donneesModel->getTousLesExercices(),
        ];

        return view('v_exercice_saisie', $data);
    }

    public function sauvegarderExercice()
    {
        $id = $this->request->getPost('id');  // ID de l'exercice si modification
        $idProgramme = $this->request->getPost('idProgramme');

        // AJOUT : On récupère l'ID de l'exercice existant sélectionné (optionnel)
        $idExistant = $this->request->getPost('idExistant');

        $data = [
            'id' => $id,
            'idProgramme' => $idProgramme,
            'idExistant' => $idExistant,  // On passe ce champ au modèle
            'libelle' => $this->request->getPost('libelle'),
            'nbSeries' => $this->request->getPost('nbSeries'),
            'charge' => $this->request->getPost('charge'),
        ];

        $this->actionInDB->saveExercice($data);

        return redirect()
            ->to('seance/modification/' . $idProgramme)
            ->with('succes', 'Exercice enregistré avec succès.');
    }

    public function supprimerExercice($idExercice, $idProgramme)
    {
        // On supprime seulement le lien dans la table 'jointure'
        $this->actionInDB->supprimerLienExercice($idExercice, $idProgramme);

        // On redirige vers le bon programme grâce à l'ID passé en paramètre
        return redirect()
            ->to('seance/modification/' . $idProgramme)
            ->with('succes', 'Exercice retiré du programme.');
    }

    // ...
    public function monterExercice($idExercice, $idProgramme)
    {
        // On passe idProgramme au modèle
        $this->actionInDB->changerOrdre($idExercice, $idProgramme, 'monter');
        return redirect()->to('seance/modification/' . $idProgramme);
    }

    public function descendreExercice($idExercice, $idProgramme)
    {
        $this->actionInDB->changerOrdre($idExercice, $idProgramme, 'descendre');
        return redirect()->to('seance/modification/' . $idProgramme);
    }
    // ...

    public function administrerProgramme()
    {
        helper('form');
        $data = [
            'cssPage' => 'choix.css',
            'titrePage' => 'Gestion des programmes',
            'programmes' => $this->donneesModel->getLesProgrammes(),
        ];
        return view('v_admin_programmes', $data);
    }

    public function sauvegarderProgramme()
    {
        $id = $this->request->getPost('id');
        $libelle = $this->request->getPost('libelle');

        if (!empty($libelle)) {
            $this->actionInDB->saveProgramme([
                'id' => $id,
                'libelle' => $libelle
            ]);
            return redirect()->to('categorie/administrer')->with('succes', 'Programme mis à jour.');
        }
        return redirect()->back()->with('erreur', 'Nom vide.');
    }

    public function supprimerProgramme($id)
    {
        $this->actionInDB->deleteProgramme($id);
        return redirect()->to('categorie/administrer')->with('succes', 'Programme supprimé.');
    }

    public function supprimerSeance($idSeance)
    {
        $this->actionInDB->deleteSeance($idSeance);
        return redirect()->to('historique')->with('succes', 'Séance supprimée.');
    }
}