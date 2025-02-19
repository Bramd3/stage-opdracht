<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/api/search', 'CompanyController::search');
$routes->get('/api/company/(:segment)', 'CompanyController::getCompany/$1');