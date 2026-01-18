<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('general', 'Home::general');
$routes->get('historique', 'Home::historique');

$routes->get('seance/detail/(:num)', 'Home::detail/$1');