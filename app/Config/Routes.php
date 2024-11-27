<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('test-db', 'DatabaseTest::index');

$routes->get('/', 'Home::index');

$routes->get('/sign-up', 'Auth::signup');
$routes->get('/login', 'Auth::login');
$routes->get('/logout', 'AuthController::logout');
$routes->get('/verify-user', 'AuthController::verifyUser');
$routes->get('/thank-you', 'AuthController::thankYou');
$routes->get('/resend-verification', 'AuthController::resendVerificationLink');


$routes->post('sign-up', 'AuthController::signup');
$routes->post('login', 'AuthController::login');
$routes->get('logout', 'AuthController::logout');

$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('/characters', 'Character::index');
    $routes->post('/characters', 'Character::saveCharacter');
    $routes->delete('/characters/(:any)', 'Character::deleteCharacter/$1');
    $routes->get('/characters/(:any)', 'Character::viewCharacter/$1');
    $routes->get('/user/characters', 'Character::savedCharacters');
    $routes->get('/user/characters/page/(:any)', 'Character::savedCharactersData/$1');
});
