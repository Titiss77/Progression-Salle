<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('seances', 'Home::seances');
$routes->get('historique', 'Home::historique');

$routes->get('seance/detail/(:num)', 'Home::detail/$1');

$routes->get('(:num)', 'Home::choix/$1');

$routes->get('(:num)/(:num)', 'Action::choix/$1/$2');