<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('test-db', 'DatabaseTest::index');

$routes->get('/', 'Home::index');

$routes->get('/signup', 'Auth::signup');
$routes->get('/login', 'Auth::login');
$routes->get('/list-characters', 'Character::index');
$routes->get('/list-characters/(:any)', 'Character::viewCharacter/$1');
