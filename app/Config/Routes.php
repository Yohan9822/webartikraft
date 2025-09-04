<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Home Page
$routes->add('/', 'Home::index');
$routes->add('home', 'Home::index');
$routes->add('setlanguage', 'Home::setLanguageWeb');

/**
 * Company
 */
$routes->group('company', function ($routes) {
    $routes->add('', 'CompanyController::index');
});
/**
 * Furnishing
 */
$routes->group('furnishing', function ($routes) {
    $routes->add('', 'ProductController::index');
});
/**
 * Bamboo
 */
$routes->group('bamboo', function ($routes) {
    $routes->add('', 'BambooController::index');
});
/**
 * Contact Page
 */
$routes->group('contact', function ($routes) {
    $routes->add('', 'ContactController::index');
});
