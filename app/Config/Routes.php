<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Homepage route
$routes->get('/', 'Home::index', ['filter' => 'auth']);



// API-route om KVK-gegevens op te halen
$routes->get('/fetch-kvk', 'KvkController::fetchData');

// Alternatieve route voor KVK-data ophalen
$routes->get('kvk/fetchData', 'KvkController::fetchData');

// Hoofdpagina voor KVK-zoekopdrachten
$routes->get('kvk', 'KvkController::index');

// Route voor bedrijfsdetails op basis van KVK-nummer
$routes->get('company/(:num)', 'KvkController::show/$1');

$routes->get('/login', 'AuthController::login');
$routes->post('/loginProcess', 'AuthController::loginProcess');
$routes->get('/register', 'AuthController::register');
$routes->post('/registerProcess', 'AuthController::registerProcess');
$routes->get('/logout', 'AuthController::logout', ['filter' => 'auth']);
$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'auth']);
