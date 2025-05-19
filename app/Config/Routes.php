<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Home Page
$routes->add('/', 'Home::index');
$routes->add('home', 'Home::index');

/**
 * Product Page
 */
$routes->group('products', function ($routes) {
    $routes->add('', 'ProductController::index');
    $routes->add('detail/(:any)', 'ProductController::detailPage/$1');
});
/**
 * About Page
 */
$routes->group('about', function ($routes) {
    $routes->add('', 'AboutController::index');
});
