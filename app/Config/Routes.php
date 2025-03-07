<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Public routes
$routes->get('/', 'Home::index');

service('auth')->routes($routes);

// Auth routes
$routes->get('logout', 'AuthController::logout');

// Admin routes
$routes->group('admin', ['namespace' => 'App\Controllers\Admin', 'filter' => 'adminAuth'], function ($routes) {
    $routes->get('dashboard', 'Dashboard::index');
});

// Public routes
$routes->group('public', ['namespace' => 'App\Controllers\Public'], function ($routes) {
    $routes->get('home', 'Home::index');
    $routes->get('login', 'Auth::login');
});
