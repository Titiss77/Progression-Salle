<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('general', 'Home::general');
$routes->get('seances', 'Home::seances');

$routes->get('seance/detail/(:num)', 'Home::detail/$1');