<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Pages::index');
$routes->get('/about', 'Pages::about');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attemptLogin');
$routes->post('logout', 'Auth::logout');
$routes->get('/customers', 'Customers::index');
$routes->get('customers/new', 'Customers::new');
$routes->post('customers/new', 'Customers::create');
$routes->get('customers/edit/(:num)', 'Customers::edit/$1');
$routes->post('customers/edit/(:num)', 'Customers::update/$1');
$routes->get('/users', 'Users::index');
$routes->get('users/new', 'Users::new');
$routes->post('users/new', 'Users::create');
$routes->get('users/edit/(:num)', 'Users::edit/$1');
$routes->post('users/edit/(:num)', 'Users::update/$1');
