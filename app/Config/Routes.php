<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Homepage route, alleen toegankelijk voor ingelogde gebruikers
$routes->get('/', 'Home::index', ['filter' => 'auth']);

// API-route om KVK-gegevens op te halen
$routes->get('/fetch-kvk', 'KvkController::fetchData');

// Alternatieve route voor KVK-data ophalen
$routes->get('kvk/fetchData', 'KvkController::fetchData');

// Hoofdpagina voor KVK-zoekopdrachten
$routes->get('kvk', 'KvkController::index');

// Route voor het tonen van bedrijfsdetails op basis van KVK-nummer
$routes->get('company/(:num)', 'KvkController::show/$1');

// Loginpagina (GET) en loginverwerking (POST)
$routes->get('/login', 'AuthController::login'); // Toon loginformulier
$routes->post('/loginProcess', 'AuthController::loginProcess'); // Verwerk inlogpoging

// Registratiepagina (GET) en registratieverwerking (POST)
$routes->get('/register', 'AuthController::register'); // Toon registratieformulier
$routes->post('/registerProcess', 'AuthController::registerProcess'); // Verwerk registratie

// Logout route, alleen toegankelijk voor ingelogde gebruikers
$routes->get('/logout', 'AuthController::logout', ['filter' => 'auth']); // Log de gebruiker uit en stuur naar loginpagina

// Dashboard route, alleen toegankelijk voor ingelogde gebruikers
$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'auth']); // Toon het dashboard
