<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('home', 'Home::index');
$routes->get('enter', 'UserController::enter'); // Para exibir a view
$routes->post('users/login', 'UserController::login'); // Para processar o login
$routes->post('users/register', 'UserController::register'); // Para processar o register