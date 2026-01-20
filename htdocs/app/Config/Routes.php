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

$routes->post('seance/enregistrer', 'Action::enregistrer');

$routes->get('exercice/ajouter/(:num)', 'Action::ajouterExercice/$1');

$routes->get('exercice/modifier/(:num)', 'Action::modifierExercice/$1');

$routes->post('exercice/sauvegarder', 'Action::sauvegarderExercice');

$routes->get('exercice/supprimer/(:num)', 'Action::supprimerExercice/$1');

$routes->get('exercice/monter/(:num)', 'Action::monterExercice/$1');
$routes->get('exercice/descendre/(:num)', 'Action::descendreExercice/$1');

$routes->get('categorie/administrer', 'Action::administrerProgramme');
$routes->post('categorie/sauvegarder', 'Action::sauvegarderProgramme');
$routes->get('categorie/supprimer/(:num)', 'Action::supprimerProgramme/$1');