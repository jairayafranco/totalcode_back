<?php
$router->get('/api/orders', 'OrderController@fetchOrders');
$router->post('/api/auth/login', 'AuthController@login');
$router->post('/api/auth/logout', 'AuthController@logout');
// $router->post('/api/auth/verifyjwt', 'AuthController@verifyJWT');
