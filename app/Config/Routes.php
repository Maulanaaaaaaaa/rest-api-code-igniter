<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Grup API
$routes->group('api', function ($routes) {
    // Auth
    $routes->post('register', 'AuthController::register');
    $routes->post('login', 'AuthController::login');

    // Jurusan
    $routes->get('jurusan', 'JurusanController::index');
    $routes->get('jurusan/(:num)', 'JurusanController::show/$1');
    $routes->post('jurusan', 'JurusanController::create');
    $routes->put('jurusan/(:num)', 'JurusanController::update/$1');
    $routes->delete('jurusan/(:num)', 'JurusanController::delete/$1');

    // Prodi
    $routes->get('prodi', 'ProdiController::index');
    $routes->get('prodi/(:num)', 'ProdiController::show/$1');
    $routes->post('prodi', 'ProdiController::create');
    $routes->put('prodi/(:num)', 'ProdiController::update/$1');
    $routes->delete('prodi/(:num)', 'ProdiController::delete/$1');

    // Users
    $routes->get('users', 'UserController::index');
    $routes->get('users/(:num)', 'UserController::show/$1');
});
