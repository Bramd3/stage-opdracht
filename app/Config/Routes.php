<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/fetch-kvk', 'KvkController::fetchData');
$routes->get('kvk/fetchData', 'KvkController::fetchData');
$routes->get('kvk', 'KvkController::index');


