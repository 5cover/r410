<?php

use App\Controllers\Home;
use App\Controllers\Dblp;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', [Home::class, 'index']);
$routes->get('dblp', fn() => (new Dblp())->author("Laurent d'Orazio"));
