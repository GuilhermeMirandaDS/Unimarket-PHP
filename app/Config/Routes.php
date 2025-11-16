<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::first');
$routes->get('home', 'Home::index');
$routes->get('my-products/(:num)', 'Home::myproducts/$1');


// Rotas dos usuários
$routes->get('enter', 'UserController::enter'); // Para exibir a view
$routes->post('users/login', 'UserController::login'); // Para processar o login
$routes->post('users/register', 'UserController::register'); // Para processar o register
$routes->get('logout', 'UserController::logOut');

// Rotas dos produtos
$routes->get('product/(:num)', 'ProductController::productInfo/$1');
$routes->get('products', 'ProductController::search');
$routes->post('my-products/add', 'ProductController::add');
$routes->delete('products/remove/(:num)', 'ProductController::delete/$1');


// Rotas das categorias
$routes->get('category/(:num)', 'CategoryController::search/$1');