<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/comments', 'CommentController::index'); // Маршрут для просмотра комментариев
$routes->post('/comments/add', 'CommentController::add'); // Маршрут для добавления комментария
$routes->delete('comments/(:num)', 'CommentController::delete/$1');