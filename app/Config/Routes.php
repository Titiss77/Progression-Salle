<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('seances', 'Home::seances');
$routes->get('historique', 'Home::historique');

$routes->get('seance/detail/(:num)', 'Home::detail/$1');

$routes->get('(:num)', 'Home::choix/$1');
$routes->get('(:num)/(:num)', 'Action::choix/$1/$2');

$routes->get('seance/creation/(:num)', 'Action::creation/$1');
$routes->get('seance/modification/(:num)', 'Action::modification/$1');

// Route pour traiter le formulaire d'enregistrement
$routes->post('seance/enregistrer', 'Action::enregistrer');

// Afficher le formulaire d'ajout
$routes->get('exercice/ajouter/(:num)', 'Action::ajouterExercice/$1'); 

// Afficher le formulaire de modification
$routes->get('exercice/modifier/(:num)', 'Action::modifierExercice/$1');

// Traiter la sauvegarde (Création ou Update)
$routes->post('exercice/sauvegarder', 'Action::sauvegarderExercice');

// Supprimer un exercice
$routes->get('exercice/supprimer/(:num)', 'Action::supprimerExercice/$1');

$routes->get('exercice/monter/(:num)', 'Action::monterExercice/$1');
$routes->get('exercice/descendre/(:num)', 'Action::descendreExercice/$1');